<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Offer;
use App\Models\Task;
use App\Models\UserProjectTask;
use App\SMS;
use Illuminate\Http\Request;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\User;
use App\Models\Payment;
use App\Models\Profession;
use App\Models\SeparateUserLog;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Spatie\PdfToImage\Pdf;
use DB;
use View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateUserGuideSeenStatus(Request $request){
        $user = Auth::user();
        $user = User::where('id',$user->id)->first();
        $user->user_guide_seen = 1;
        $user->save();

        Session::put('user_guide_seen', $user->user_guide_seen);

        return ['status' => 200, 'reason' => 'User guide seen status successfully updated'];
    }

    private function createUserSession($user){
        Session::put('user_id', $user->id);
        Session::put('unique_id', $user->unique_id);
        Session::put('role_id',$user->role_id);
        Session::put('username', $user->username);
        Session::put('user_email', $user->email);
        Session::put('first_name', $user->first_name);
        Session::put('last_name', $user->last_name);
        Session::put('user_photo', $user->photo);
    }

    public function promotion(Request $request){
        try {
            if (Auth::check()) {
                if(!Common::is_user_login()){
                    return redirect('error_404');
                }
                $countries = Country::where('status','active')->get();

                $user = user::where('id', $request->id)->first();
                $offer = Offer::first();

                if($user->status=='pending'){
                    return redirect('verify_account');
                }

                $payment = Payment::where('user_id', $user->id)->first();
                if (!empty($payment) && $payment->payment_status == 'Completed') {
                    $shipment = UserShipment::where('user_id', $user->id)->first();
                    if (empty($shipment)) {
                        return redirect('select_shipment/'.$user->id);
                    }

                    return redirect('all_project');
                }
                if ($request->ajax()) {
                    $returnHTML = View::make('promotion', compact('user','offer','countries'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('promotion', compact('user','offer','countries'));
            }
            else{
                return redirect('login');
            }
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'promotion', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function profile(Request $request){
        try {
            if (Auth::check()) {

                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                $user = User::where('users.id', Session::get('user_id'))
                    ->select('users.*', 'user_shipments.shipment_date', 'professions.title as profession_name')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->leftJoin('professions', 'professions.id', '=', 'users.profession')
                    ->first();

                if ($request->ajax()) {
                    $returnHTML = View::make('user.profile', compact('user'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }

                /*
                 * Check user status and redirect
                 * */
                $user_status = Common::checkPaymentAndShipentStatus();
                if($user_status=='empty_payment'){
                    return redirect('promotion/'.$user->id);
                }
                if($user_status=='empty_shipment'){
                    return redirect('select_shipment/'.$user->id);
                }
                /*
                 * User status checking ends
                 * */

                return view('user.profile', compact('user'));
            }
            else{
                return redirect('login');
            }
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'profile', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function userEdit(Request $request)
    {
        if (Auth::check()) {

            if(!Common::is_user_login()){
                return redirect('error_404');
            }

            $user = User::where('users.id', $request->id)
                ->select('users.*', 'user_shipments.shipment_date','user_shipments.shipment_date_update_count')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->first();

            $professions = Profession::where('status', 'active')->get();
            if ($request->ajax()) {
                $returnHTML = View::make('user.user_edit',
                    compact('user', 'professions'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.user_edit', compact('user', 'professions'));
        }
        else{
            return redirect('login');
        }
    }

    public function resetPassword(Request $request)
    {
        if (Auth::check()) {

            if(!Common::is_user_login()){
                return redirect('error_404');
            }

            $user = User::where('users.id', Session::get('user_id'))->first();

            if($request->ajax()) {
                $returnHTML = View::make('user.reset-password', compact('user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.reset-password', compact('user'));
        }
        else{
            return redirect('login');
        }
    }

    public function userUpdate(Request $request){
        try {
            DB::beginTransaction();

            $user_id = $request->user_id;
            $phone_number = Common::formatPhoneNumber($request->phone);

            $user = User::where('id',$user_id)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->country_code = $request->country_code;
            $user->phone = $phone_number;
            $user->profession = $request->profession;
            //$user->birthday = date('Y-m-d', strtotime($request->birthday));
            if($request->gender !=''){
                $user->gender = $request->gender;
            }

            /*
             * Update profile photo
             * */
            $photo_path = '';
            if($request->hasFile('photo')){
                $file = $request->File('photo');
                $extension = $file->getClientOriginalExtension();
                $file_name = md5(rand(10,10000)).time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/users');
                $file->move($destinationPath, $file_name);

                $photo_path = 'uploads/users/'.$file_name;
                $user->photo = $photo_path;
                Session::put('user_photo', $photo_path);
            }

            $user->save();

            /*
             * Update shipping date
             * */

            $result = $this->updateShipingDate($request,$user_id);

            /*
             * Add pink offers if gender updated to Female
             * */
            if($request->gender !='' && $request->gender != $request->old_gender){
                $result = $this->managePinkOffer($request,$user_id);
                $this->increaseGenderChangeCount($user_id);
            }

            DB::commit();

            return ['status' => 200, 'reason' => 'User successfully updated','photo_path'=>$photo_path];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updateUser', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function updateShipingDate($request,$user_id){
        $date_increased = 0;
        if($request->shipment_date !='' && $request->shipment_date != $request->old_shipment_date){
            if(Common::getDateDiffDays($request->shipment_date,$request->old_shipment_date)>0) { // If date increased
                $date_increased = 1;
            }

            /*
             * Update shipment date
             * */
            $shipment = UserShipment::where('user_id',$user_id)->first();
            $shipment->shipment_date = date('Y-m-d',strtotime($request->shipment_date));
            $shipment->shipment_date_update_count = $shipment->shipment_date_update_count+1;
            $shipment->save();

            /*
             * Update project task due date
             * */
            $result = $this->updateProjectTaskDueDate($user_id,$request->shipment_date);

            return 'Date updated';
        }
        return 'Date not updated';
    }

    private function updateProjectTaskDueDate($user_id,$shipment_date){
        $user_projects = UserProject::where('user_id',$user_id)
            ->select('user_projects.*','projects.day_add_with')
            ->join('projects','projects.id','=','user_projects.project_id')
            //->where('projects.day_add_with','shipment_date')
            //->where('user_projects.project_id',34)
            ->get();

        /*
         * Update due date
         * */
        $result = Common::updateUserProjectTaskDueDate($user_projects,$shipment_date);

        return $result;

    }

    private function managePinkOffer($request,$user_id){
        /*
         * add/remove pink offer
         * */
        if($request->gender == 'Female'){
            $result = $this->addPinkOffer($user_id,$request->shipment_date);
        }
        else{
            $result = $this->removePinkOffer($user_id,$request->shipment_date);
        }

        return $result;
    }

    private function addPinkOffer($user_id){
        $user = User::where('users.id',$user_id)
            ->select('users.*','user_payments.created_at as purchase_date')
            ->join('user_payments','user_payments.user_id','=','users.id')
            ->first();
        $purchase_date = $user->purchase_date;
        $shipment = UserShipment::where('user_id',$user_id)->first();
        /*
         * Get user project based on selected offer
         * */
        $projects = Common::getOfferedProject('Female',0,0);

        $result = Common::saveUserProject($projects,$user_id,$shipment,$purchase_date);

        return $result;
    }

    private function removePinkOffer($user_id){
        /*
         * Get user project based on selected offer
         * */
        $projects = Common::getOfferedProject('Female',0,0);

        foreach($projects as $key=>$project){
            $user_project = UserProject::select('id')
                ->where('user_id',$user_id)
                ->where('project_id',$project->id)
                ->first();

            /*
             * Delete User pink projects
             * */
            UserProject::where('user_id',$user_id)->where('project_id',$project->id)->delete();

            /*
             * Delete user pink project tasks
             * */
            UserProjectTask::where('user_project_id',$user_project->id)->delete();
        }
        return 'Successfully deleted';

    }

    private function increaseGenderChangeCount($user_id){
        $user = User::select('users.*')->where('users.id',$user_id)->first();
        $user->gender_update_count = $user->gender_update_count+1;
        $user->save();

        return 'Successfully updated';
    }

    public function updatePassword(Request $request){
        try {
            $user = User::where('id',$request->user_id)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            return ['status' => 200, 'reason' => 'Password successfully updated'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updatePassword', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function userList(Request $request){
        try {
            if (Auth::check()) {

                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                /*
                 * Removing all duplicate user shipment record
                 * */
                //$result = Common::removeAllDuplicateShippingRecord();

                $users = User::where('users.email', Session::get('user_email'))
                    ->select('users.*', 'user_shipments.shipment_date','separate_user_logs.otp','separate_user_logs.created_at as otp_sent_at')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->leftJoin('separate_user_logs', 'separate_user_logs.user_id', '=', 'users.id')
                    ->where('users.id','!=',Session::get('user_id'))
                    ->where('users.status','active')
                    ->orderBy('users.id', 'ASC')
                    ->get();
                if ($request->ajax()) {
                    $returnHTML = View::make('user.user_list', compact('users'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }


                /*
                 * Check user status and redirect
                 * */
                $user = Auth::user();
                $user_status = Common::checkPaymentAndShipentStatus();
                if($user_status=='empty_payment'){
                    return redirect('promotion/'.$user->id);
                }
                if($user_status=='empty_shipment'){
                    return redirect('select_shipment/'.$user->id);
                }
                /*
                 * User status checking ends
                 * */


                return view('user.user_list', compact('users'));
            }
            else{
                return redirect('login');
            }
            //echo "<pre>"; print_r($users); echo "</pre>";
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userList', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function userDetails(Request $request){
        try {
            if (Auth::check()) {

                if(!Common::is_user_login()){
                    return redirect('error_404');
                }

                $user = User::where('users.id', $request->id)
                    ->select('users.*', 'user_shipments.shipment_date', 'professions.title as profession_name')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->leftJoin('professions', 'professions.id', '=', 'users.profession')
                    ->first();
                if ($request->ajax()) {
                    $returnHTML = View::make('user.user_details', compact('user'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.user_details', compact('user'));
            }
            else{
                return redirect('login');
            }
            //echo "<pre>"; print_r($users); echo "</pre>";
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userDetails', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function addUser(Request $request)
    {
        if (Auth::check()) {

            if(!Common::is_user_login()){
                return redirect('error_404');
            }

            $user = User::where('users.id', Session::get('user_id'))->first();

            if($request->ajax()) {
                $returnHTML = View::make('user.create_new_user', compact('user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.create_new_user', compact('user'));
        }
        else{
            return redirect('login');
        }
    }

    public function storeNewUser(Request $request){
        try {

            $parentUser = User::where('email',Session::get('user_email'))->first();

            $lastUser = User::orderBy('id','DESC')->first();
            if(!empty($lastUser)){
                $unique_id = Common::generateUniqueNumber($lastUser->id+1);
            }
            else{
                $unique_id = Common::generateUniqueNumber(1);
            }
            $phone_number = Common::formatPhoneNumber($request->phone);

            $user = new User();
            $user->parent_id = $parentUser->id;
            $user->unique_id = $unique_id;
            $user->username = $request->username;
            $user->email = Session::get('user_email');
            $user->phone = $phone_number;
            $user->country_code = $request->country_code;
            $user->password = $parentUser->password;
            $user->role = 3;
            $user->status = 'pending';
            $user->save();

            /*
             * Send confirmation email to admin
             */
            $email_to = [Common::ADMIN_EMAIL];
            $email_cc = [];
            $email_bcc = [];

            $emailData['from_email'] = Common::FROM_EMAIL;
            $emailData['from_name'] = Common::FROM_NAME;
            $emailData['email'] = $email_to;
            $emailData['email_cc'] = $email_cc;
            $emailData['email_bcc'] = $email_bcc;
            $emailData['user'] = $user;
            $emailData['subject'] = Common::SITE_TITLE.'- New user creation';

            $emailData['bodyMessage'] = '';

            $view = 'emails.admin_new_user_registration_email';

            $result = SendMails::sendMail($emailData, $view);

            /*
             * Send confirmation email to user
             */
            $email_to = [Session::get('user_email')];
            $email_cc = [];
            $email_bcc = [];

            $emailData['from_email'] = Common::FROM_EMAIL;
            $emailData['from_name'] = Common::FROM_NAME;
            $emailData['email'] = $email_to;
            $emailData['email_cc'] = $email_cc;
            $emailData['email_bcc'] = $email_bcc;
            $emailData['user'] = $user;
            $emailData['subject'] = Common::SITE_TITLE.'- New User creation confirmation';

            $emailData['bodyMessage'] = '';

            $view = 'emails.new_user_creation_confirmation_email';

            $result = SendMails::sendMail($emailData, $view);

            /*
             * Send registration confirmation message
             * */

            $response = Common::sendRegistrationConfirmationSms($request->username,$phone_number);

            /*
             * Store sms sending record
             * */
            $message_body = 'Dear '.$request->username.', Welcome to VUJADETEC. Your registration has been completed.';
            $result = Common::storeSmsRecord($user->id, $message_body);

            return ['status' => 200, 'reason' => 'New user created successfully','user_id'=>$user->id];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'storeNewUser', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function sendUserOtp(Request $request){
        try {
            /*
             * Authenticate user
             * */
            $old_password = Auth::user()->password;
            if (!Hash::check($request->password, $old_password)) {
                return ['status' => 401, 'reason' => 'Authentication failed'];
            }

            /*
             * Check if user created with this email address. If not then return false
             * */
            $hasUser = User::where('email',$request->email)->first();
            if(empty($hasUser)){
                return ['status' => 401, 'reason' => 'Sorry! No user registered with this email address'];
            }

            /*
             * Check if email address is the parent user's email address. If yes then return false
             * */
            $thisUser = User::where('id',$request->user_id)->first();
            if($thisUser->email==$request->email){
                return ['status' => 401, 'reason' => "You can not send OTP to this users's current parent user"];
            }

            /*
             * store separate user email log
             * */
            $otp = Common::generaterandomNumber(4);

            // Delete previous log if any
            SeparateUserLog::where('user_id',$request->user_id)->delete();

            $s_user_log = NEW SeparateUserLog();
            $s_user_log->user_id = $request->user_id;
            $s_user_log->email = $request->email;
            $s_user_log->otp = $otp;
            $s_user_log->is_used = 0;
            $s_user_log->created_at = date('Y-m-d h:i:s');
            $s_user_log->save();

            /*
             * Send otp confirmation email
             */
            $email_to = [$request->email];
            $email_cc = [];
            $email_bcc = [];

            $emailData['from_email'] = Common::FROM_EMAIL;
            $emailData['from_name'] = Common::FROM_NAME;
            $emailData['email'] = $email_to;
            $emailData['email_cc'] = $email_cc;
            $emailData['email_bcc'] = $email_bcc;
            $emailData['otp'] = $otp;
            $emailData['subject'] = Common::SITE_TITLE.'- Member separation request';

            $emailData['bodyMessage'] = '';

            $view = 'emails.user_separation_otp_email';

            $result = SendMails::sendMail($emailData, $view);

            /*
             * Send OTP confirmation message
             * */
            $message_body = 'Your One Time Password (OTP) to transfer the info is '.$otp.'. Validity for OTP is 24 hours. Please contact info@vujadetec.com if you need further assistance.';
            //$response = SMS::sendOtpSms($thisUser->phone,$message_body);

            return ['status' => 200, 'reason' => 'An email with OTP have been sent to '.$request->email];
        } catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'sendUserOtp', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function separateUser(Request $request){
        try {
            DB::beginTransaction();

            $s_user = SeparateUserLog::where('otp',$request->otp)
                ->where('user_id',$request->user_id)
                ->where('is_used',0)
                ->first();
            if(empty($s_user)){
                return [ 'status' => 401, 'reason' => 'Invalid OTP. Try again with valid OTP'];
            }

            $t1 = strtotime( date('Y-m-d h:i:s') );
            $t2 = strtotime( $s_user->created_at );
            $diff = $t1 - $t2;
            $hours = $diff / ( 60 * 60 );

            if($hours>24){
                return [ 'status' => 401, 'reason' => 'OTP expired. Try again with valid OTP'];
            }

            $childUserDetails = User::where('id',$request->user_id)->first();
            $oldParentUserDetails = User::where('id',$childUserDetails->parent_id)->first();

            /*
             * Get new parent user
             * */
            $parent_user = User::where('email',$s_user->email)->first();

            /*
             * Check if there has child for this new parent user
             * */
            $child_users = User::where('email',$s_user->email)
                ->join('user_shipments','user_shipments.user_id','=','users.id')
                ->get();

            if(count($child_users)>0){
                /*
                 * If separating as child user then only update user's parent email address
                 * */
                $child_user = User::where('id',$request->user_id)->first();
                $child_user->parent_id = $parent_user->id;
                $child_user->email = $s_user->email;
                $child_user->save();
            }
            else{
                /*
                 * If separating as parent user then Export all it's properties to selected parent user
                 * */


                /*
                 * Export user payment
                 * */
                $payment = Payment::where('user_id',$request->user_id)->first();
                if(!empty($payment)){
                    $payment->user_id = $parent_user->id;
                }
                $payment->save();

                /*
                 * Export user shipment
                 * */
                $shipment = UserShipment::where('user_id',$request->user_id)->first();
                if(!empty($shipment)){
                    $shipment->user_id = $parent_user->id;
                }
                $shipment->save();

                /*
                 * Export user project
                 * */
                UserProject::where('user_id',$request->user_id)
                    ->update(['user_id' => $parent_user->id]);

                /*
                 * Export user messages
                 * */

                /*
                 * Now remove old child user
                 * */
                User::where('id',$request->user_id)->delete();
            }

            // Delete this otp history
            $s_user = SeparateUserLog::where('otp',$request->otp)->where('user_id',$request->user_id)->delete();

            DB::commit();

            /*
             * Send separation confirmation message
             * */
            $message_body = 'Dear '.$childUserDetails->username.', Welcome to VUJADETEC. ';
            $message_body .= $oldParentUserDetails->username.' transferred all your records. Please read the user guide & visit www.vujadetec.com to get more information about our product & services.';
            $response = SMS::sendSingleSms($childUserDetails->phone,$message_body);

            /*
             * Store sms sending record
             * */
            $result = Common::storeSmsRecord($childUserDetails->id, $message_body);

            return ['status' => 200, 'reason' => 'User separated successfully'];
        } catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'separateUser', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
