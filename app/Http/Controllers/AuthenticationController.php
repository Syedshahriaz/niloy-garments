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
        Session::put('role_id',$user->role_id);
        Session::put('username', $user->username);
        Session::put('user_email', $user->email);
        Session::put('first_name', $user->first_name);
        Session::put('last_name', $user->last_name);
        Session::put('user_photo', $user->photo);
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
