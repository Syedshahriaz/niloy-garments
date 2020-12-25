<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use App\Models\SubscriptionPlan;
use App\Models\TaskTitle;
use App\SMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserShipment;
use App\Models\Payment;
use App\Models\UserProject;
use App\Models\UserPermission;
use App\Models\Message;
use App\Models\UserSms;
use App\Models\Buyer;
use App\Models\User;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class UserController extends Controller
{

    public function userList(Request $request)
    {
        try {
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            if(!Common::can_access('users')){
                return redirect('error_404');
            }

            $offer = Offer::first();
            $subscription_plans = SubscriptionPlan::select('subscription_plans.*')
                ->where('subscription_plans.status','active')
                ->get();

            $users = User::with('projects.passed_task','projects.recent_due_task')
                ->select('users.*', 'user_payments.payment_status', 'user_shipments.shipment_date','messages.id as message_id')
                ->leftJoin('user_payments', 'user_payments.user_id', '=', 'users.id')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->leftJoin('messages', 'messages.user_id', '=', 'users.id')
                ->where('users.role',3)
                ->where('users.status', '!=', 'deleted')
                ->orderBy('users.id', 'ASC')
                ->get();

            if ($request->ajax()) {
                $returnHTML = View::make('admin.user.all_user', compact('offer','subscription_plans','users'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }

            return view('admin.user.all_user', compact('offer','subscription_plans','users'));
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userList', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deletedUserList(Request $request)
    {
        try {
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            $offer = Offer::first();

            $users = User::with('projects.passed_task','projects.recent_due_task')
                ->select('users.*', 'user_shipments.shipment_date','messages.id as message_id')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->leftJoin('messages', 'messages.user_id', '=', 'users.id')
                ->where('users.role',3)
                ->where('users.status', 'deleted')
                ->orderBy('users.id', 'ASC')
                ->get();

            if ($request->ajax()) {
                $returnHTML = View::make('admin.user.deleted_user', compact('offer','users'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }

            return view('admin.user.deleted_user', compact('offer','users'));
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'deletedUserList', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function dashboard(Request $request)
    {
        try {
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }

            $user_id = $request->u_id;

            $user = User::select('unique_id','username')
                ->where('id',$user_id)
                ->first();

            /*$shipment = UserShipment::where('user_id', $user_id)->first();
            if (empty($shipment)) {
                return redirect('select_offer/'.$user_id);
            }*/
            $projects = UserProject::with('tasks','running_task','last_task')
                ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id')
                ->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id')
                ->leftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
                ->where('user_projects.user_id', $user_id)
                ->where('projects.status', 'active')
                ->where('projects.type','!=', 'free')
                ->groupBy('projects.id')
                ->get();

            $free_projects = UserProject::with('free_tasks','free_running_task','free_last_task')
                ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id')
                ->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id')
                ->leftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
                ->where('user_projects.user_id', $user_id)
                ->where('projects.status', 'active')
                ->where('projects.type', 'free')
                ->groupBy('projects.id')
                ->get();

            $task_titles = TaskTitle::where('status','!=','deleted')
                ->get();

            $buyer = Buyer::where('user_id',$user_id)->first();

            if ($request->ajax()) {
                $returnHTML = View::make('admin.user.dashboard',
                    compact('user_id','user','projects','free_projects','task_titles','buyer'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.user.dashboard',compact('user_id','user','projects','free_projects','task_titles','buyer'));
            //echo "<pre>"; print_r($projects); echo "</pre>";
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'dashboard', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $admin_user = Auth::user();

            $userIds = explode(',',$request->user_id);

            if($request->status=='deleted'){
                $deleted_at  = date('Y-m-d h:i:s');
            }
            else{
                $deleted_at = NULL;
            }

            User::whereIn('id', $userIds)
            ->update(
                [
                    'status' => $request->status,
                    'updated_by' => $admin_user->id,
                    'updated_at' => date('Y-m-d h:i:s'),
                    'deleted_at' => $deleted_at,
                ]
            );

            return ['status'=>200, 'reason'=>'Status Successfully updated'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'updateStatus', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updatePayment(Request $request)
    {
        try {
            DB::beginTransaction();

            $user_id = $request->user_id;
            $gender = $request->gender;
            $offer = $request->offer;
            $shipment_date = $request->shipment_date;

            $user = User::where('id',$user_id)->first();
            $user->gender = $gender;
            $user->status = 'active';
            $user->user_type = 'premium';
            $user->save();

            /*
             * Subscription plan price
             * */
            $subscription_plan = SubscriptionPlan::select('subscription_plans.*','offer_prices.currency','offer_price_details.offer_price','countries.name as country_name')
                ->join('offer_price_details','offer_price_details.subscription_plan_id','=','subscription_plans.id')
                ->join('offer_prices','offer_prices.id','=','offer_price_details.offer_price_id')
                ->join('countries','countries.id','=','offer_prices.country_id')
                ->where('subscription_plans.status','active')
                ->where('countries.dial_code',$user->country_code)
                ->first();

            /*
             * Update payment information
             * */
            $payment = Payment::where('user_id', $user_id)->first();
            if(empty($payment)){
                $payment = NEW Payment();
            }
            $payment->user_id = $user_id;
            $payment->amount = $subscription_plan->offer_price;
            $payment->store_amount = $subscription_plan->offer_price;
            $payment->payment_status = 'Completed';
            $payment->txn_id = 'Manual_'.Common::generaterandomNumber(4);
            $payment->payment_date = date('Y-m-d h:i:s');
            $payment->payment_source = 'manual';
            $payment->validation_status = 'VALID';
            $payment->response = '';
            $payment->updated_at = date('Y-m-d h:i:s');
            $payment->save();

            /*
             * Save offer details
             * */
            $shipment = UserShipment::where('user_id',$user_id)->first();
            if(empty($shipment)){
                $shipment = NEW UserShipment();
                $shipment->user_id = $user_id;
                $shipment->has_ofer_1 = 0;
                $shipment->has_ofer_2 = 0;
                $shipment->subscription_plan_id = $request->subscription_plan_id;

                $shipment->save();
            }

            /*
             * Save
             * */

            $purchase_date = $payment->payment_date;
            /*
             * Save shipment date
             * */
            $shipment = Common::saveShipmentDetails($user_id,$gender,$shipment_date,$offer);

            $has_offer_1 = $shipment->has_ofer_1;
            $has_offer_2 = $shipment->has_ofer_2;

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

            /*
             * Check and send task warning email and sms
             * */
            $result = Common::sendTaskWarningEmail($user_id);

            return ['status'=>200, 'reason'=>'User payment successfully updated'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'updatePayment', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deleteUserPermanently(Request $request)
    {
        try {
            DB::beginTransaction();
            $user_id = $request->user_id;
            User::where('id', $user_id)->delete();

            /*
             * Delete user payment data
             * */
            Payment::where('user_id',$user_id)->delete();

            /*
             * Delete user shipment
             * */
            UserShipment::where('user_id',$user_id)->delete();

            /*
             * Delete user project data
             * */
            UserProject::where('user_id',$user_id)->delete();

            /*
             * Delete user permission
             * */
            UserPermission::where('user_id',$user_id)->delete();

            /*
             * Delete user message
             * */
            Message::where('user_id',$user_id)->delete();

            /*
             * Delete user sms
             * */
            UserSms::where('user_id',$user_id)->delete();

            DB::commit();

            return ['status'=>200, 'reason'=>'User deleted successfully'];
        } catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'updateStatus', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateUserOffer(Request $request)
    {
        try {
            DB::beginTransaction();

            $admin_user = Auth::user();
            $user_id  = $request->user_id;

            /*
             * Save offer details
             * */
            $user = User::select('users.*','users.id as user_id','user_payments.created_at as payment_date')
                ->where('users.id',$user_id)
                ->leftJoin('user_payments','user_payments.user_id','=','users.id')
                ->first();

            $shipment = UserShipment::where('user_id',$user_id)->first();
            if(empty($shipment)){
                return [ 'status' => 401, 'reason' => 'This user did not select birth date yet.'];
            }

            $gender = $user->gender;
            $purchase_date = $user->payment_date;


            if($request->offer == 1){
                $offer_name = 'Green';
                $shipment->has_ofer_1 = 1;
                $shipment->has_ofer_2 = 0;
            }
            else{
                $offer_name = 'Red';
                $shipment->has_ofer_1 = 0;
                $shipment->has_ofer_2 = 1;
            }
            if($gender == 'Female'){
                $shipment->has_ofer_3 = 1;
            }

            $shipment->save();

            $has_offer_1 = $shipment->has_ofer_1;
            $has_offer_2 = $shipment->has_ofer_2;

            /*
             * Remove previous projects and tasks of this user
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
             * Send task warning email
             * */
            $result = Common::sendTaskWarningEmail($user_id);


            /*
             * Save notification
             * */
            $message = "Member ".$user->unique_id.": Offer have been changed to ".$offer_name;
            $result = Common::saveNotification($user,$message);

            return ['status'=>200, 'reason'=>'Offer Successfully updated'];
        } catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'updateStatus', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateUserEmail(Request $request)
    {
        try {
            DB::beginTransaction();

            $user_id  = $request->user_id;
            $email  = $request->email;

            $checkEmail = User::where('email',$request->email)->first();
            if(!empty($checkEmail) && $checkEmail->id != $user_id){
                return [ 'status' => 401, 'reason' => 'This email address already exists. Please try with another email address.'];
            }

            /*
             * Save offer details
             * */
            $user = User::select('users.*','users.id as user_id')->where('id',$user_id)->first();
            $user->email = $email;
            $user->save();

            /*
             * Update child user email
             * */
            User::where('parent_id',$user_id)
                ->update(['email' => $email]);



            DB::commit();

            /*
             * Save notification
             * */
            $message = "Member ".$user->unique_id.": Email have been changed to ".$email;
            $result = Common::saveNotification($user,$message);

            return ['status'=>200, 'reason'=>'Email Successfully updated'];
        } catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'updateUserEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function sendUserEmail(Request $request)
    {
        try {
            $userIds = explode(',',$request->user_id);
            $user_emails = User::select('email')
                ->whereIN('id',$userIds)
                ->pluck('email')
                ->toArray();

            $email_to = $user_emails;
            $email_cc = [];
            $email_bcc = [];

            $emailData['from_email'] = Common::FROM_EMAIL;
            $emailData['from_name'] = Common::FROM_NAME;
            $emailData['email'] = $email_to;
            $emailData['email_cc'] = $email_cc;
            $emailData['email_bcc'] = $email_bcc;
            $emailData['subject'] = $request->subject;

            $emailData['bodyMessage'] = $request->message;;

            $view = 'emails.user_custom_email';

            $result = SendMails::sendMail($emailData, $view);

            return ['status'=>200, 'reason'=>'Email successfully sent'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'sendUserEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function sendUserSms(Request $request)
    {
        try {
            $phones = $request->phone;
            $message_body = $request->message;
            $userIds = explode(',',$request->user_id);
            if($phones==''){ // This is a bulk sms
                $phones = User::select('phone')
                    ->whereIN('id',$userIds)
                    ->pluck('phone')
                    ->toArray();
                $phones = implode(',',$phones);
                $response = SMS::sendCampaignSms($phones,$message_body,'Attention');
            }
            else{ // This is a single sms
                $country_code = $request->country_code;
                $phones = $country_code.$phones;
                $response = SMS::sendSingleSms($phones,$message_body);
            }

            /*
             * Store sms sending record
             * */
            if(!empty($userIds)){
                foreach($userIds as $user_id){
                    $result = Common::storeSmsRecord($user_id, $message_body);
                }
            }

            return ['status'=>200, 'reason'=>'SMS successfully sent'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'sendUserEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function unlockUserGender(Request $request){
        try{
            $user = User::select('users.*','users.id as user_id')->where('id', $request->user_id)->first();
            if($user->gender_update_count != 0){
                $user->gender_update_count = 0;
            }
            $user->save();

            $message = "Member ".$user->unique_id.": Gender have been unlocked";

            /*
             * Save notification
             * */
            $result = Common::saveNotification($user,$message);

            return ['status'=>200, 'reason'=>'User gender unlocked successfully'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'unlockUserGender', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
