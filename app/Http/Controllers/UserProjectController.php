<?php

namespace App\Http\Controllers;

use App\Models\CovidVaccineDose;
use App\Models\Offer;
use App\Models\Payments;
use App\Models\TaskTitle;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Project;
use App\Models\Task;
use App\Models\Payment;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\User;
use App\Models\CovidVaccineCompany;
use App\Models\UserCovidVaccineCompany;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use View;

class UserProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function selectShipment(Request $request){
        try{
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                $offer = Offer::first();
                $user = User::where('users.id', $request->id)->first();

                /*
                 * Check if payment done for this user
                 * */
                $payment = Payment::where('user_id', $user->id)->first();
                if (empty($payment)) {
                    return redirect('promotion/'.$user->id);
                }
                if ($payment->payment_status != 'Completed') {
                    return redirect('promotion/'.$user->id);
                }

                /*
                 * Check if shipment date selected already
                 * */
                $shipment = UserShipment::where('user_id', $user->id)->first();

                if ($shipment->has_ofer_1==0 && $shipment->has_ofer_2==0) { // If no offer selected yet
                    return redirect('select_offer/'.$user->id);
                }

                if (($shipment->has_ofer_1==1 || $shipment->has_ofer_2==1) && $shipment->shipment_date != '') {
                    return redirect('all_project');
                }

                if ($request->ajax()) {
                    $returnHTML = View::make('user.project.select_shipment', compact('user','offer'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.select_shipment', compact('user','offer'));
            }
            else{
                return redirect('login');
            }
        }
         catch (\Exception $e) {
             SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'selectShipment', $e->getLine(),
                 $e->getFile(), '', '', '', '');
             // message, view file, controller, method name, Line number, file,  object, type, argument, email.
             return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
         }
    }

    public function storeShipment(Request $request){
        try{
            DB::beginTransaction();

            $shipment = UserShipment::where('user_id',$request->user_id)->first();
            if($shipment->shipment_date != ''){
                return [ 'status' => 401, 'reason' => 'You have already added your shipment date'];
            }

            /*
             * Update user
             * */
            $user = User::where('users.id',$request->user_id)
                ->select('users.*','user_payments.created_at as purchase_date')
                ->join('user_payments','user_payments.user_id','=','users.id')
                ->first();
            $user->gender = $request->gender;
            $user->save();

            $user_id = $user->id;
            $purchase_date = $user->purchase_date;
            $gender = $request->gender;
            $shipment_date = $request->shipment_date;

            /*
             * Save shipment date
             * */
            $shipment = $this->saveShipmentDetails($user_id,$gender,$shipment_date);

            $has_offer_1 = $shipment->has_ofer_1;
            $has_offer_2 = $shipment->has_ofer_2;

            /*
             * Remove previous projects and tasks of this user if user is upgrading from free to premium account
             * But keep project record for COVID 19 vaccine
             * */
            $result = Common::removeUserProject($user_id);

            /*
             * Get user project based on selected offer
             * */
            $projects = Common::getOfferedProject($gender,$has_offer_1,$has_offer_2);

            /*
             * Save user project
             * */
            $result = Common::saveUserProject($projects,$user_id,$shipment,$purchase_date);

            DB::commit();

            /*
             * check and prepare for task editable
             * */
            $result = Common::checkAndPrepareForTaskProcessing($user_id,$shipment_date);

            Session::put('selected_user',$user_id);

            /*
             * Check and send task warning email and sms
             * */
            if($user->user_type=='premium') { // Sending sms only to premium users
                $result = Common::sendTaskWarningEmail($user_id);
            }

            return ['status'=>200, 'reason'=>'Date of birth successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'storeShipment', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function saveShipmentDetails($user_id,$gender,$shipment_date){
        $shipment = UserShipment::where('user_id',$user_id)->first();
        $shipment->shipment_date = date('Y-m-d',strtotime($shipment_date));
        if($gender == 'Female'){
            $shipment->has_ofer_3 = 1;
        }
        $shipment->save();

        return $shipment;
    }

    public function allProject(Request $request){
        try{
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                /*
                 * Check if user already verified account
                 * */
                $user = Auth::user();
                if($user->parent_id ==0 && $user->status=='pending'){
                    return redirect('verify_account');
                }

                if ($request->u_id == '') {
                    if(Session::get('selected_user') != ''){
                        $user_id = Session::get('selected_user');
                    }
                    else{
                        $user_id = Session::get('user_id');
                    }
                } else {
                    $user_id = $request->u_id;
                }

                Session::put('selected_user',$user_id);

                /*
                 * Check if user subscription is expired or not
                 * */
                $user = User::where('users.id', $user_id)->first();

                $user_covid_vaccine_company = UserCovidVaccineCompany::where('user_id',$user->id)
                    ->first();

                $setting = Setting::select('message_to_user')->first();
                $covid_vaccine_companies = CovidVaccineCompany::select('covid_vaccine_companies.*')
                    ->where('status','active')
                    ->get();

                $shipment = UserShipment::where('user_id', $user_id)->first();
                if (empty($shipment)) {
                    return redirect('promotion/'.$user_id);
                }
                if ($shipment->shipment_date == '') {
                    return redirect('select_offer/'.$user_id);
                }

                /*
                 * Removing duplicate user shipment record
                 * */
                $result = Common::removeUserDuplicateShippingRecord($user_id);


                $child_users = User::where('users.email', Session::get('user_email'))
                    ->select('users.*', 'user_shipments.shipment_date')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->whereIn('users.status',['active','pending','expired'])
                    ->groupBy('user_shipments.user_id')
                    //->orderBy('parent_id','ASC')
                    ->get();

                $projects = UserProject::with('running_task','last_task','completed_tasks')
                    ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id', 'user_projects.has_special_date','user_projects.special_date','user_projects.special_date_update_count','user_projects.user_id')
                    ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                    ->join('tasks', 'tasks.project_id', '=', 'projects.id')
                    ->where('user_projects.user_id', $user_id)
                    ->where('projects.status', 'active')
                    ->where('projects.type','!=', 'free')
                    ->groupBy('projects.id')
                    ->get();

                $free_projects = UserProject::with('free_running_task','free_last_task','free_completed_tasks')
                    ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id', 'user_projects.has_special_date','user_projects.special_date','user_projects.special_date_update_count','user_projects.user_id')
                    ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                    ->join('tasks', 'tasks.project_id', '=', 'projects.id')
                    ->where('user_projects.user_id', $user_id)
                    ->where('projects.status', 'active')
                    ->where('projects.type', 'free')
                    ->groupBy('projects.id')
                    ->get();

                if ($request->ajax()) {
                    $returnHTML = View::make('user.project.all_project',
                        compact('user_id','user','setting', 'child_users', 'shipment', 'projects','free_projects','covid_vaccine_companies','user_covid_vaccine_company'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.project.all_project',
                    compact('user_id','user','setting', 'child_users', 'shipment', 'projects','free_projects','covid_vaccine_companies','user_covid_vaccine_company'));
            }
            else{
                return redirect('login');
            }
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'allProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectSpecialDate(Request $request){
        try{
            DB::beginTransaction();

            $user_id = $request->user_id;

            $user_projects = UserProject::where('user_id',$user_id)
                    ->where('has_special_date',1)
                    ->get();

            foreach($user_projects as $key=>$u_project){
                $u_project->special_date = date('Y-m-d', strtotime($request->special_date));
                $u_project->special_date_update_count = $u_project->special_date_update_count+1;
                $u_project->save();

                $project_tasks = UserProjectTask::where('user_project_id',$u_project->id)
                    ->select('user_project_tasks.*','tasks.days_to_add')
                    ->join('tasks','tasks.id','=','user_project_tasks.task_id')
                    ->get();

                /*
                 * Add user project tasks due date
                 * */
                $result = $this->addSpecialDateToProjectTask($project_tasks,$request->special_date);
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'updateProjectSpecialDate', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateCovidCompany(Request $request){
        try{
            $user_id = $request->user_id;

            $user_vaccine_company = UserCovidVaccineCompany::where('user_id',$user_id)->first();
            if(empty($user_vaccine_company)){
                $user_vaccine_company = NEW UserCovidVaccineCompany();
            }

            $user_vaccine_company->user_id = $user_id;
            $user_vaccine_company->company_id = $request->covid_vaccine_company;
            $user_vaccine_company->user_project_id = $request->user_project_id;
            $user_vaccine_company->dose_date = date('Y-m-d');
            $user_vaccine_company->save();

            DB::beginTransaction();
            /*
             * First remove user project tasks for this user project if any
             * */
            $result = Common::removeUserProjectTask($request->user_project_id);

            /*
             * Now adding new tasks for this user projects
             * */
            $user_project = UserProject::where('id',$request->user_project_id)
                ->first();
            $shipment = UserShipment::where('user_id',$request->user_id)->first();
            $covid_doses = CovidVaccineDose::where('company_id',$request->covid_vaccine_company)->get();

            $result = Common::saveUserCovidProjectTask($covid_doses,$user_project,$shipment,$user_vaccine_company);

            DB::commit();

            /*
             * Sending warning message (if needed)
             * */
            $result = Common::sendTaskWarningEmail($user_id,$request->user_project_id);

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'updateCovidCompany', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function addSpecialDateToProjectTask($project_tasks,$special_date){
        foreach($project_tasks as $key=>$p_task){
            $p_task->due_date = date('Y-m-d', strtotime($special_date. ' + '.$p_task->days_to_add.' days'));
            $p_task->original_delivery_date = date('Y-m-d', strtotime($special_date. ' + '.$p_task->days_to_add.' days'));
            $p_task->save();
        }
    }

    public function myProjectTask(Request $request){
        try{
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                $user_project_id = $request->id;

                /*
                 * Getting project details
                 * */
                $projectDetails = UserProject::with('free_completed_tasks')
                    ->select('projects.*','user_projects.id as user_project_id')
                    ->join('projects','projects.id','=','user_projects.project_id')
                    ->where('user_projects.id',$user_project_id)
                    ->first();

                /*
                 * Getting user details
                 * */
                $user = UserProject::select('users.id','users.username', 'users.email','users.status','has_special_date','special_date')
                    ->join('users','users.id','=','user_projects.user_id')
                    ->where('user_projects.id',$user_project_id)
                    ->first();

                /*
                 * Getting covid vaccine companies
                 * */
                $covid_vaccine_companies = CovidVaccineCompany::select('covid_vaccine_companies.*')
                    ->where('status','active')
                    ->get();

                /*
                 * Getting user selected covid vaccine company
                 * */
                $user_covid_vaccine_company = UserCovidVaccineCompany::where('user_id',$user->id)->first();

                //echo "<pre>"; print_r($user_covid_vaccine_company); echo "</pre>"; exit();
                if($projectDetails->type=='free'){
                    $tasks = UserProjectTask::select('user_project_tasks.*', 'covid_vaccine_doses.dose_name as title', 'covid_vaccine_doses.company_id', 'covid_vaccine_doses.rule', 'covid_vaccine_doses.status as task_status', 'tasks.project_id','covid_vaccine_doses.days_to_add','covid_vaccine_doses.days_range_start','covid_vaccine_doses.days_range_end','covid_vaccine_doses.update_date_with','covid_vaccine_doses.has_freeze_rule','covid_vaccine_doses.freeze_dependent_with','covid_vaccine_doses.skip_background_rule','projects.has_offer_1')
                        ->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                        ->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id')
                        ->join('projects', 'projects.id', '=', 'tasks.project_id')
                        ->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id')
                        ->where('user_project_id', $user_project_id)
                        ->where('covid_vaccine_doses.status', 'active')
                        ->get();
                }
                else{
                    $tasks = UserProjectTask::select('user_project_tasks.*', 'task_title.name as title', 'tasks.rule', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule','projects.has_offer_1')
                        ->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                        ->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id')
                        ->join('projects', 'projects.id', '=', 'tasks.project_id')
                        ->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id')
                        ->where('user_project_id', $user_project_id)
                        ->where('tasks.status', 'active')
                        ->get();
                }

                $task_titles = TaskTitle::where('status','!=','deleted')
                    ->get();

                if (count($tasks) != 0) {
                    $project = Project::select('projects.*')
                        ->where('id', $projectDetails->id)
                        ->first();
                } else {
                    $project = array();
                }

                $shipment = UserProject::select('user_shipments.*')
                    ->join('user_shipments','user_shipments.user_id','user_projects.user_id')
                    ->where('user_projects.id',$user_project_id)
                    ->first();

                if ($request->ajax()) {
                    if(empty($user)){
                        return [ 'status' => 401, 'reason' => 'This project have been removed.'];
                    }

                    $returnHTML = View::make('user.project.my_project_task',
                        compact('user_project_id','user','project', 'projectDetails', 'tasks','shipment','task_titles','covid_vaccine_companies','user_covid_vaccine_company'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }

                if(empty($user)){ // User task not generated yet
                    return redirect('error_404');
                }
                if($user->email != Session::get('user_email')){ // Logged in user allowed only
                    return redirect('error_404');
                }
                if($user->has_special_date==1 && $user->special_date == ''){ // Need to select special date
                    return redirect('all_project?u_id='.$user->id);
                }

                return view('user.project.my_project_task', compact('user_project_id','user','project', 'projectDetails', 'tasks', 'shipment','task_titles','covid_vaccine_companies','user_covid_vaccine_company'));
            }
            else{
                return redirect('login');
            }
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectTaskDeliveryStatus(Request $request){
        try{
            $date_updated = 0;
            $date_increased = 0;
            $daysAdded = 0;
            $task = UserProjectTask::where('user_project_tasks.id',$request->project_task_id)
                ->select('user_project_tasks.*','tasks.has_freeze_rule','user_projects.user_id','projects.type as project_type')
                ->leftjoin('tasks','tasks.id','=','user_project_tasks.task_id')
                ->join('user_projects','user_projects.id','=','user_project_tasks.user_project_id')
                ->leftjoin('projects','projects.id','=','user_projects.project_id')
                ->first();

            if($task->delivery_date_update_count>1){
                return ['status'=>200, 'reason'=>'Task already completed and locked.'];
            }

            $shipment = UserShipment::where('user_id', $task->user_id)->first();

            /*
             * Check if original delivery date updated and then update next tasks original delivery date
             * */
            if($request->original_delivery_date !='' && ($request->original_delivery_date != $request->old_delivery_date)){
                $date_updated = 1;
                //$delivery_date_update_count  = $task->delivery_date_update_count+1;

                $daysAdded = Common::getDateDiffDays($request->original_delivery_date,$request->old_delivery_date);
                if($daysAdded>0) { // If date increased
                    $date_increased = 1;
                }
            }

            /*
             * Check if task made done by checking done tag
             * */
            $delivery_date_update_count  = $task->delivery_date_update_count+1;
            $task->delivery_date_update_count = $task->delivery_date_update_count+1;

            if($request->original_delivery_date !=''){
                $task->status = 'completed';
                $task->original_delivery_date = date('Y-m-d', strtotime($request->original_delivery_date));

                $this->makePreviousTaskNotEditable($request->project_task_id,$task->user_project_id);

            }
            $task->save();

            $project_type = $task->project_type;

            /*
             * Make immediate next task to processing
             * */
            if($delivery_date_update_count < 2 ){
                $next_task = $this->makeImmediateNextTaskProcessing($request->project_task_id,$task->user_project_id,$shipment->shipment_date,$project_type);
                if(!empty($next_task)){
                    $result = $this->makePreviousNotInitiateTaskForeverFreeze($task->user_project_id);
                }
            }

            /*
             * Update next task original due date if date updated by user
             * */
            if($date_updated==1){
                if($task->project_type !='free'){
                    $result = $this->updateNextTaskOriginalDeliveryDate($request->project_task_id,$task->user_project_id,$date_increased,$daysAdded);
                }
                else{
                    $result = $this->updateNextFreeTaskOriginalDeliveryDate($request->project_task_id,$task->user_project_id,$date_increased,$daysAdded);
                }
            }

            /*
             * Sending warning message (if needed)
             * */
            $result = Common::sendTaskWarningEmail($task->user_id,$task->user_project_id);

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserProjectController', 'myProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function makePreviousTaskNotEditable($project_task_id,$user_project_id){
        $prev_tasks = UserProjectTask::select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_tasks.id','<',$project_task_id)
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('delivery_date_update_count','<',2)
            ->orderBy('user_project_tasks.id','ASC')
            ->get();
        foreach($prev_tasks as $task){
            $taskData = UserProjectTask::where('id',$task->id)->first();
            $taskData->delivery_date_update_count = 2;
            $taskData->status = 'completed';
            $taskData->save();
        }
    }

    private function makeImmediateNextTaskProcessing($project_task_id,$user_project_id,$shipment_date,$project_type='free'){
        $next_task = $this->getNextTask($project_task_id,$user_project_id,$project_type);
        if(!empty($next_task)){
            $task_in_date_range = Common::task_in_date_range($shipment_date,$next_task->days_range_start,$next_task->days_range_end);
            if($task_in_date_range==0){
                $result = $this->makeImmediateNextTaskProcessing($next_task->id,$user_project_id,$shipment_date,$project_type);
            }
            else{
                $next_task->status = 'processing';
                $next_task->save();

                return 1;
            }
        }
        return 1;
    }

    private function getNextTask($project_task_id,$user_project_id,$type='free'){
        if($type != 'free'){
            $next_task = UserProjectTask::where('user_project_tasks.id','>',$project_task_id);
            $next_task = $next_task->select('user_project_tasks.*','projects.name as project_name','task_title.name as task_name', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule','users.username','users.email','users.phone');
            $next_task = $next_task->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id');
            $next_task = $next_task->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id');
            $next_task = $next_task->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
            $next_task = $next_task->leftJoin('user_projects','user_projects.id','=','user_project_tasks.user_project_id');
            $next_task = $next_task->leftJoin('projects','projects.id','=','user_projects.project_id');
            $next_task = $next_task->leftJoin('users','users.id','=','user_projects.user_id');
            $next_task = $next_task->where('user_project_id',$user_project_id);
            $next_task = $next_task->where('tasks.status','active');
            $next_task = $next_task->where('user_project_tasks.freeze_forever',0);
            $next_task = $next_task->orderBy('user_project_tasks.id','ASC');
            $next_task = $next_task->first();
        }
        else{
            $next_task = UserProjectTask::where('user_project_tasks.id','>',$project_task_id);
            $next_task = $next_task->select('user_project_tasks.*','projects.name as project_name','covid_vaccine_doses.dose_name as task_name', 'covid_vaccine_doses.status as task_status', 'projects.id as project_id','covid_vaccine_doses.days_to_add','covid_vaccine_doses.days_range_start','covid_vaccine_doses.days_range_end','covid_vaccine_doses.update_date_with','covid_vaccine_doses.has_freeze_rule','covid_vaccine_doses.freeze_dependent_with','covid_vaccine_doses.skip_background_rule','users.username','users.email','users.phone');
            $next_task = $next_task->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id');
            $next_task = $next_task->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id');
            $next_task = $next_task->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id');
            $next_task = $next_task->leftJoin('user_projects','user_projects.id','=','user_project_tasks.user_project_id');
            $next_task = $next_task->leftJoin('projects','projects.id','=','user_projects.project_id');
            $next_task = $next_task->leftJoin('users','users.id','=','user_projects.user_id');
            $next_task = $next_task->where('user_project_id',$user_project_id);
            $next_task = $next_task->where('covid_vaccine_doses.status','active');
            $next_task = $next_task->where('user_project_tasks.freeze_forever',0);
            $next_task = $next_task->orderBy('user_project_tasks.id','ASC');
            $next_task = $next_task->first();
        }

        return $next_task;
    }

    private function updateNextTaskOriginalDeliveryDate($project_task_id,$user_project_id,$date_increased,$daysAdded){
        /*
         * Get all next task of this user project
         * */

        $previous_task = UserProjectTask::select('user_project_tasks.*','tasks.id as task_id','tasks.date_update_dependent_with','tasks.only_date_update_dependent_with')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_tasks.id',$project_task_id)
            ->first();

        $project_tasks = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*','tasks.date_update_dependent_with','tasks.only_date_update_dependent_with','projects.name as project_name','task_title.name as task_name', 'tasks.status as task_status', 'tasks.project_id','tasks.days_to_add','tasks.days_range_start','tasks.days_range_end','tasks.update_date_with','tasks.has_freeze_rule','tasks.freeze_dependent_with','tasks.skip_background_rule','users.id as user_id','users.username','users.email','users.phone')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->join('task_title', 'task_title.id', '=', 'tasks.title_id')
            ->join('user_projects','user_projects.id','=','user_project_tasks.user_project_id')
            ->join('projects','projects.id','=','user_projects.project_id')
            ->join('users','users.id','=','user_projects.user_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->whereIn('user_project_tasks.status',['not initiate','processing'])
            ->where('tasks.update_date_with','self_task')
            ->get();


        foreach($project_tasks as $key=>$p_task){
            $user_id = $p_task->user_id;

            if($p_task->date_update_dependent_with==''){
                /*
                 * Check if task has only_date_update_dependent_with parent task and that parent task is the previous task or not.
                 * */
                if($p_task->only_date_update_dependent_with=='' || $p_task->only_date_update_dependent_with==$previous_task->task_id){
                    $taskData = UserProjectTask::where('id',$p_task->id)->first();
                    if($date_increased==1){ // If date increased
                        $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' + '.abs(round($daysAdded)).' days'));
                        $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' + '.abs(round($daysAdded)).' days'));
                    }
                    else{
                        $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' - '.abs(round($daysAdded)).' days'));
                        $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' - '.abs(round($daysAdded)).' days'));
                    }
                    $taskData->save();
                }
            }
            else{
                if($p_task->date_update_dependent_with==$previous_task->task_id || $p_task->date_update_dependent_with==$previous_task->date_update_dependent_with){
                    $taskData = UserProjectTask::where('id',$p_task->id)->first();
                    if($date_increased==1){ // If date increased
                        $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' + '.abs(round($daysAdded)).' days'));
                        $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' + '.abs(round($daysAdded)).' days'));
                    }
                    else{
                        $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' - '.abs(round($daysAdded)).' days'));
                        $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' - '.abs(round($daysAdded)).' days'));
                    }
                    $taskData->save();
                }
            }
        }
    }

    private function updateNextFreeTaskOriginalDeliveryDate($project_task_id,$user_project_id,$date_increased,$daysAdded){
        /*
         * Get all next task of this user project
         * */
        $project_tasks = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*')
            ->leftJoin('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->leftJoin('covid_vaccine_doses', 'covid_vaccine_doses.id', '=', 'user_project_tasks.covid_vaccine_dose_id')
            ->leftJoin('task_title', 'task_title.id', '=', 'tasks.title_id')
            ->join('user_projects','user_projects.id','=','user_project_tasks.user_project_id')
            ->join('projects','projects.id','=','user_projects.project_id')
            ->join('users','users.id','=','user_projects.user_id')
            ->where('user_project_id',$user_project_id)
            ->where('covid_vaccine_doses.status','active')
            ->whereIn('user_project_tasks.status',['not initiate','processing'])
            ->get();


        foreach($project_tasks as $key=>$p_task){
            $user_id = $p_task->user_id;

            $taskData = UserProjectTask::where('id',$p_task->id)->first();
            if($date_increased==1){ // If date increased
                $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' + '.abs(round($daysAdded)).' days'));
                $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' + '.abs(round($daysAdded)).' days'));
            }
            else{
                $taskData->due_date = date('Y-m-d', strtotime($taskData->due_date. ' - '.abs(round($daysAdded)).' days'));
                $taskData->original_delivery_date = date('Y-m-d', strtotime($taskData->original_delivery_date. ' - '.abs(round($daysAdded)).' days'));
            }
            $taskData->save();
        }
    }

    private function disableNextTaskOriginalDeliveryDateEdit($project_task_id,$user_project_id){
        /*
         * Get all next task of this user project
         * */
        $project_tasks = UserProjectTask::where('user_project_tasks.id','>',$project_task_id)
            ->select('user_project_tasks.*')
            ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
            ->where('user_project_id',$user_project_id)
            ->where('tasks.status','active')
            ->where('user_project_tasks.freeze_forever',2)
            ->get();

        foreach($project_tasks as $key=>$p_task){
            $taskData = UserProjectTask::where('id',$p_task->id)->first();
            $taskData->freeze_forever = 1;
            $taskData->save();
        }
    }

    private function makePreviousNotInitiateTaskForeverFreeze($user_project_id){
        /*
         * Get all previous not initiate task of this user project
         * */
        $processing_task = UserProjectTask::select('user_project_tasks.*')
            ->where('user_project_id',$user_project_id)
            ->where('user_project_tasks.status','processing')
            ->first();

        if(!empty($processing_task)){
            $project_tasks = UserProjectTask::where('user_project_tasks.id','<',$processing_task->id)
                ->select('user_project_tasks.*')
                ->join('tasks', 'tasks.id', '=', 'user_project_tasks.task_id')
                ->where('user_project_id',$user_project_id)
                ->where('tasks.status','active')
                ->where('user_project_tasks.status','not initiate')
                ->get();

            foreach($project_tasks as $key=>$p_task){
                $taskData = UserProjectTask::where('id',$p_task->id)->first();
                $taskData->freeze_forever = 1;
                $taskData->save();
            }
        }
    }
}
