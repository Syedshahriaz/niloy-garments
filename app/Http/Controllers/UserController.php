<?php

namespace App\Http\Controllers;

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
use Session;
use Spatie\PdfToImage\Pdf;
use DB;

class UserController extends Controller
{
    public function registration(Request $request){
        //try {
            if($request->token !=''){
                $email = base64_decode($request->token);
                $reffer_user = User::where('email',$email)->first();
            }
            else{
                $reffer_user = array();
            }
            if($request->ajax()) {
                $returnHTML = View::make('registration', compact('reffer_user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('registration', compact('reffer_user'));
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'create', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function store(Request $request){
        //try {
        $lastUser = User::orderBy('id','DESC')->first();
        if(!empty($lastUser)){
            $unique_id = Common::generateUniqueNumber($lastUser->id+1);
        }
        else{
            $unique_id = Common::generateUniqueNumber(1);
        }

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->unique_id = $unique_id;
        $user->role = 3;
        $user->save();

        /*
         * Send confirmation email
         */
        $email_to = [$request->email];
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['subject'] = 'Niloy Garments- Registration confirmation';

        $emailData['bodyMessage'] = '';

        $view = 'emails.registration_confirmation_email';

        $result = SendMails::sendMail($emailData, $view);

        return ['status' => 200, 'reason' => 'Registration successfully done. An email with login link have been sent to your email address.'];
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'storeUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function selectUser(Request $request){
        //try {
            if (Auth::check()) {
                $users = User::where('email', Session::get('user_email'))->get();
                if (count($users) == 1) {
                    $user = $users[0];
                    $this->createUserSession($user);

                    return redirect('promotion');
                }
                if ($request->ajax()) {
                    $returnHTML = View::make('select_user', compact('users'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('select_user', compact('users'));
            }
            else{
                return redirect('login');
            }
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'selectUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function multiTinent(Request $request){
        //try {
            $user = User::where('id',$request->user_id)->first();

            $this->createUserSession($user);

            return redirect('promotion');
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'multiTinent', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
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
        //try {
            if (Auth::check()) {
                $user = user::where('id', $request->id)->first();

                $payment = Payment::where('user_id', $user->id)->first();
                if (!empty($payment) && $payment->payment_status == 'Completed') {
                    $shipment = UserShipment::where('user_id', $user->id)->first();
                    if (empty($shipment)) {
                        return redirect('select_shipment');
                    }

                    return redirect('all_project');
                }
                if ($request->ajax()) {
                    $returnHTML = View::make('promotion', compact('user'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('promotion', compact('user'));
            }
            else{
                return redirect('login');
            }
        // }
        // catch (\Exception $e) {
        //     SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'promotion', $e->getLine(),
        //         $e->getFile(), '', '', '', '');
        //     // message, view file, controller, method name, Line number, file,  object, type, argument, email.
        //     return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        // }
    }

    public function profile(Request $request){
        //try {
            if (Auth::check()) {
                $user = User::where('users.id', Session::get('user_id'))
                    ->select('users.*', 'user_shipments.shipment_date', 'professions.title as profession_name')
                    ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                    ->leftJoin('professions', 'professions.id', '=', 'users.profession')
                    ->first();
                if ($request->ajax()) {
                    $returnHTML = View::make('user.profile', compact('user'))->renderSections()['content'];
                    return response()->json(array('status' => 200, 'html' => $returnHTML));
                }
                return view('user.profile', compact('user'));
            }
            else{
                return redirect('login');
            }
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'profile', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function userEdit(Request $request)
    {
        if (Auth::check()) {
            $user = User::where('users.id', $request->id)
                ->select('users.*', 'user_shipments.shipment_date')
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
    public function resetPassword()
    {
        if (Auth::check()) {
            $user = User::where('users.id', Session::get('user_id'))->first();
            return view('user.reset-password', compact('user'));
        }
        else{
            return redirect('login');
        }
    }

    public function userUpdate(Request $request){
        //try {
            $user = User::where('id',$request->user_id)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->profession = $request->profession;
            //$user->birthday = date('Y-m-d', strtotime($request->birthday));
            $user->gender = $request->gender;

            /*
             * Update profile photo
             * */
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


            return ['status' => 200, 'reason' => 'User successfully updated'];
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updateUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function updatePassword(Request $request){
        //try {
            $user = User::where('id',$request->user_id)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            return ['status' => 200, 'reason' => 'Password successfully updated'];
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updatePassword', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function userList(Request $request){
        //try {
        if (Auth::check()) {
            $users = User::where('users.email', Session::get('user_email'))
                ->select('users.*', 'user_shipments.shipment_date')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->where('users.id','!=',Session::get('user_id'))
                ->orderBy('users.id', 'ASC')
                ->get();
            if ($request->ajax()) {
                $returnHTML = View::make('user.user_list', compact('users'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.user_list', compact('users'));
        }
        else{
            return redirect('login');
        }
        //echo "<pre>"; print_r($users); echo "</pre>";
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userList', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function userDetails(Request $request){
        //try {
        if (Auth::check()) {
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
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userDetails', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function addUser(Request $request)
    {
        if (Auth::check()) {
            $user = User::where('users.id', Session::get('user_id'))->first();
            //Auth::logout();

            return view('user.create_new_user', compact('user'));
            //return redirect()->route('registration',['token'=>base64_encode($user->email)]);
        }
        else{
            return redirect('login');
        }
    }

    public function storeNewUser(Request $request){
        //try {

        $parentUser = User::where('email',$request->email)->first();

        $lastUser = User::orderBy('id','DESC')->first();
        if(!empty($lastUser)){
            $unique_id = Common::generateUniqueNumber($lastUser->id+1);
        }
        else{
            $unique_id = Common::generateUniqueNumber(1);
        }

        $user = new User();
        $user->unique_id = $unique_id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $parentUser->password;
        $user->role = 3;
        $user->save();

        /*
         * Send confirmation email
         */
        /*$email_to = [$request->email];
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['subject'] = 'Niloy Garments- Registration confirmation';

        $emailData['bodyMessage'] = '';

        $view = 'emails.registration_confirmation_email';

        $result = SendMails::sendMail($emailData, $view);*/

        return ['status' => 200, 'reason' => 'New user created successfully','user_id'=>$user->id];
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'storeNewUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function sendUserOtp(Request $request){
        //try {
            /*
             * Authenticate user
             * */
            $result = Auth::attempt([
                'email' => Session::get('user_email'),
                'password' => $request->password
            ]);

            if (!$result) {
                return ['status' => 401, 'reason' => 'Authentication failed'];
            }

            /*
             * store separate user email log
             * */
            $otp = Common::generaterandomNumber(4);

            $s_user = SeparateUserLog::where('email', $request->email)->first();
            if(empty($s_user)){
                $s_user = NEW SeparateUserLog();
            }
            $s_user->email = $request->email;
            $s_user->otp = $otp;
            $s_user->is_used = 0;
            $s_user->save();

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
            $emailData['subject'] = 'Niloy Garments- User separation request';

            $emailData['bodyMessage'] = '';

            $view = 'emails.user_separation_otp_email';

            $result = SendMails::sendMail($emailData, $view);


            return ['status' => 200, 'reason' => 'An email with OTP have been sent to '.$request->email];
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'sendUserOtp', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function separateUser(Request $request){
        //try {
            DB::beginTransaction();

            $s_user = SeparateUserLog::where('otp',$request->otp)
                ->where('is_used',0)
                ->first();
            if(empty($s_user)){
                return [ 'status' => 401, 'reason' => 'Invalid OTP. Try again with valid OTP'];
            }
            $s_user->is_used = 1;
            $s_user->save();

            /*
             * Get new parent user
             * */
            $parent_user = User::where('email',$s_user->email)->first();

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

            DB::commit();

            return ['status' => 200, 'reason' => 'User separated successfully'];
        /*} catch (\Exception $e) {
            DB::rollback();
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'separateUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }
}
