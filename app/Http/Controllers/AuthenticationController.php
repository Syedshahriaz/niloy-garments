<?php

namespace App\Http\Controllers;

use App\Helpers\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Common;
use App\SendMails;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use \Validator;
use Session;

class AuthenticationController extends Controller
{
    public function __construct()
    {

    }

    public function registration(Request $request){
        try {
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
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'create', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function storeUser(Request $request){
        try {
            $lastUser = User::orderBy('id','DESC')->first();
            if(!empty($lastUser)){
                $unique_id = Common::generateUniqueNumber($lastUser->id+1);
            }
            else{
                $unique_id = Common::generateUniqueNumber(1);
            }

            $phone_number = Common::formatPhoneNumber($request->phone);

            $parentUser = User::where('email',$request->email)->where('parent_id',0)->first();

            $user = new User();
            if(!empty($parentUser)){
                $user->parent_id = $parentUser->id;
            }
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $phone_number;
            $user->country_code = $request->country_code;
            $user->password = bcrypt($request->password);
            $user->unique_id = $unique_id;
            $user->role = 3;
            $user->status = 'pending';
            $user->save();

            $token = base64_encode($user->id."#".$user->email);
            $userDetails = User::where('id',$user->id)->first();
            $userDetails->verification_token = $token;
            $userDetails->save();

            $verification_link = url('verify_email').'?token='.$token;

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
            $emailData['verification_link'] = $verification_link;
            $emailData['subject'] = Common::SITE_TITLE.'- Registration confirmation';

            $emailData['bodyMessage'] = '';

            $view = 'emails.registration_confirmation_email';

            $result = SendMails::sendMail($emailData, $view);

            /*
             * Send registration confirmation message
             * */

            $response = Common::sendRegistrationConfirmationSms($request->username,$phone_number);

            return ['status' => 200, 'reason' => 'Registration successfully done. An email with verification link have been sent to your email address.'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'store', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function verifyEmail(Request $request){
        try {
            $user = User::where('verification_token', $request->token)->where('status','pending')->first();
            if (empty($user)) {
                return redirect('error_404'); // Token not matched
            }
            $tokenData = base64_decode($request->token);
            $tokenExplode = explode('#',$tokenData);
            if(count($tokenExplode) !=2){
                return redirect('error_404'); // Invalid token
            }

            /*
             * Update user status
             * */
            $user->status = 'active';
            $user->email_verified_at = date('Y-m-d h:i:s');
            $user->save();

            return view('registration_confirmation');

        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'verifyEmail', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function registrationThankYou(Request $request){
        try {
            return view('registration_thankyou');
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'registrationThankYou', 'verifyEmail', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function login()
    {
        if (Common::is_user_login()) {
            return redirect('/user');
        }
        return view('auth/login');
    }

    public function postLogin(Request $request)
    {
        $result = Auth::attempt([
            'email' => trim($request->email),
            'password' => $request->password,
            'parent_id' => 0,
            'role' => 3,
            'status' => 'active',
        ], $request->has('remember'));

        if ($result) {
            $user = Auth::user();

            $this->createUserSession($user);

            return ['status' => 200, 'reason' => 'Successfully Authenticated','user_id'=>$user->id,'role_id'=>$user->role];
        } else {
            return ['status' => 401, 'reason' => 'Invalid credentials'];
        }
    }

    private function createUserSession($user){
        Session::put('user_id', $user->id);
        Session::put('unique_id', $user->unique_id);
        Session::put('role',$user->role);
        Session::put('username', $user->username);
        Session::put('user_email', $user->email);
        Session::put('first_name', $user->first_name);
        Session::put('last_name', $user->last_name);
        Session::put('user_photo', $user->photo);
        Session::put('user_guide_seen', $user->user_guide_seen);
    }

    public function forgotPassword()
    {
        if (Common::is_user_login()) {
            return redirect('/user');
        }
        return view('auth/forgot_password');
    }

    /**
     * Send Password Reset Email
     *
     * @param Request $request
     * @return array
     */
    public function passwordResetEmail(Request $request)
    {
        $result = User::where('email', trim($request->email))->where('role_id', 1)->where("status","active")->first();

        if (!empty($result)) {

            //Password Rest Mail Send
            PasswordReset::sendPasswordResetTokenForParent($result);

            return [
                'status' => 200,
                'reason' => 'An email with password reset link have been sent to your email address.'
            ];
        } else {
            return ['status' => 401, 'reason' => 'We did not find this email address in our system'];
        }
    }

    public function resetPassword($token, $email)
    {
        if (Common::is_user_login()) {
            return redirect('/user');
        }


        $emailToken = base64_decode($email);
        $tokenDetails = explode('#', $emailToken);

        if (count($tokenDetails) != 2) {
            return redirect("/");
        }else{
            $email = $tokenDetails[0];
        }

        $tokenData = DB::table('password_resets')
            ->where('token', $token)
            ->where('email', $email)->first();

        if ($tokenData) {
            $user = User::where('email', $tokenData->email)->first();

            if (!$user) {
                return redirect()->back()->withErrors(['email' => 'Email not found']);
            } else {
                return view('auth/reset_password', compact('tokenData'));
            }
        } else {
            return redirect("/");
        }
    }


    public function savePassword(Request $request)
    {

        if (Common::is_user_login()) {
            return redirect('/user');
        }

        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|confirmed'
        ]);

        //check if input is valid before moving on
        if ($validator->fails()) {
            return ['status' => 201, 'reason' => $validator->errors()->all()];
        }

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->where('email', $request->email)->first();

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            return ['status' => 201, 'reason' => 'Invalid token'];
        }

        $user = User::where('email', $tokenData->email)->where('status','active')->first();

        // Redirect the user back if the email is invalid
        if (!$user) {
            return ['status' => 201, 'reason' => 'Email Not Found'];
        }

        //Hash and update the new password
        $user->password = Hash::make($password);
        $user->save(); //or $user->update();

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        return ['status' => 200, 'reason' => 'Password updated successfully'];
    }

    public function logout()
    {
        Auth::logout();

        Session::forget('user_id');
        Session::forget('username');
        Session::forget('user_email');
        Session::forget('first_name');
        Session::forget('last_name');

        return redirect('login');
    }
}
