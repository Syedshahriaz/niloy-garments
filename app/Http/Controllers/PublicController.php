<?php

namespace App\Http\Controllers;

use App\Common;
use App\SendMails;
use Illuminate\Http\Request;
use App\Models\User;
use App\SMS;
use Auth;
use DB;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emailPasswordLink(Request $request)
    {
        try {
            $user = User::where('email', $request->email)
                ->where('parent_id',0)
                ->first();
            if(empty($user)){
                return ['status'=>401, 'reason'=>'Sorry no user found with this email address in the system.'];
            }

            $otp = Common::generaterandomNumber(4);

            $token = base64_encode(time().'#'.$user->id);

            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $otp, 'created_at'=>date('Y-m-d h:i:s')]
            );

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
            $emailData['otp'] = $otp;
            $emailData['subject'] = Common::SITE_TITLE.'- Password reset request';

            $emailData['bodyMessage'] = '';

            $view = 'emails.password_reset_email';

            $result = SendMails::sendMail($emailData, $view);

            /*
             * Send password reset OTP as sms
             * */
            $message_body = 'A password reset request have been received.';
            if($otp !=''){
                $message_body .='Use '.$otp.' as OTP to reset your password.';
            }
            $message_body .='Please visit www.vujadetec.com to get more information about our product & services.';
            $response = SMS::sendSingleSms($user->phone,$message_body);

            return ['status'=>200, 'token'=>$token, 'reason'=>'Password reset OTP have been sent to your email and phone number.'];
        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $token = $request->token;
            if($token==''){
                return redirect('error_404');
            }
            $tokenData = base64_decode($token);
            $tokenArray = explode('#',$tokenData);
            $user_id = $tokenArray[1];

            $user = DB::table('users')
                ->where('id', $user_id)
                ->where('parent_id',0)
                ->first();
            if(empty($user)){
                return redirect('error_404');
            }

            return view('auth.passwords.reset',compact('token','user'));

        }
        catch (\Exception $e) {
            return redirect('error_404');
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $otp = $request->otp;
            $password_reset = DB::table('password_resets')->where('token', $otp)->first();
            if(empty($password_reset)){
                return ['status'=>401, 'reason'=>'Invalid OTP given.'];
            }

            $user = User::where('id', $request->user_id)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            DB::table('password_resets')->where('token',  $otp)->delete();

            return ['status'=>200, 'reason'=>'Password successfully updated'];

        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
