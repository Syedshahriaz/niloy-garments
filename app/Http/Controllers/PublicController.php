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
            $token = base64_encode(time().'#'.$user->id);

            DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at'=>date('Y-m-d h:i:s')]
            );

            $reset_link = url('reset_password').'?token='.$token;

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
            $emailData['reset_link'] = $reset_link;
            $emailData['subject'] = Common::SITE_TITLE.'- Password reset request';

            $emailData['bodyMessage'] = '';

            $view = 'emails.password_reset_email';

            $result = SendMails::sendMail($emailData, $view);

            return ['status'=>200, 'reason'=>'An email with password reset link have been sent to your email address.'];
        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $token = $request->token;
            $password_reset = DB::table('password_resets')->where('token', $token)->first();
            if(empty($password_reset)){
                return redirect('error_404');
            }

            $user = User::where('email', $password_reset->email)
                ->where('parent_id',0)
                ->first();

            return view('auth.passwords.reset',compact('token','password_reset','user'));

        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $token = $request->reset_token;
            $password_reset = DB::table('password_resets')->where('token', $token)->first();
            if(empty($password_reset)){
                return redirect('error_404');
            }

            $user = User::where('id', $request->user_id)->first();
            $user->password = bcrypt($request->password);
            $user->save();

            DB::table('password_resets')->where('token',  $token)->delete();

            return ['status'=>200, 'reason'=>'Password successfully updated'];

        }
        catch (\Exception $e) {
            return ['status'=>401, 'reason'=>'Something went wrong. Try again later.'];
        }
    }
}
