<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Session;

class UserController extends Controller
{
    public function create(Request $request){
        try {
            if($request->ajax()) {
                $returnHTML = View::make('registration')->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('registration');
        } catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'create', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function store(Request $request){
        try {
            /*
             * Check duplicate username
             * */
            $duplicateUser = User::where('username',$request->username)->first();
            if(!empty($duplicateUser)){
                return [ 'status' => 401, 'reason' => 'Duplicate username'];
            }
            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
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
            return $result;

            return ['status' => 200, 'reason' => 'Registration successfully done. An email with registration link have been sent to your email address.'];
        } catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'storeUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function selectUser(Request $request){
        try {
            $users = User::where('email',Session::get('user_email'))->get();
            if($request->ajax()) {
                $returnHTML = View::make('select_user',compact('users'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('select_user',compact('users'));
        } catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'selectUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function multiTinent(Request $request){
        try {
            return redirect('promotion');
        } catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'multiTinent', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function promotion(Request $request){
        //try {
            $user = Auth::user();
            if($request->ajax()) {
                $returnHTML = View::make('promotion',compact('user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('promotion',compact('user'));
        // } 
        // catch (\Exception $e) {
        //     SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'promotion', $e->getLine(),
        //         $e->getFile(), '', '', '', '');
        //     // message, view file, controller, method name, Line number, file,  object, type, argument, email.
        //     return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        // }
    }

    public function profile(Request $request){
        try {
            $user = User::where('id',Auth::user()->id)->first();
            if($request->ajax()) {
                $returnHTML = View::make('user.profile',compact('user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.profile',compact('user'));
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'profile', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function update(Request $request){
        try {
            $user = User::where('id',$request->user_id)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthday = date('Y-m-d', strtotime($request->birthday));
            $user->gender = $request->gender;
            $user->save();

            return ['status' => 200, 'reason' => 'User successfully updated'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updateUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updatePassword(Request $request){
        try {
            $user = User::where('id',$request->user_id)->first();
            $user->password = $request->password;
            $user->save();

            return ['status' => 200, 'reason' => 'Password successfully updated'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updatePssword', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
