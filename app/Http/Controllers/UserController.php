<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Session;
use Spatie\PdfToImage\Pdf;

class UserController extends Controller
{
    public function create(Request $request){
        //try {
            if($request->ajax()) {
                $returnHTML = View::make('registration')->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('registration');
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'create', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function store(Request $request){
        //try {
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
            $users = User::where('email',Session::get('user_email'))->get();
            if(count($users)==1){
                $user = $users[0];
                $this->createUserSession($user);

                return redirect('promotion');
            }
            if($request->ajax()) {
                $returnHTML = View::make('select_user',compact('users'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('select_user',compact('users'));
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
        Session::put('role_id',$user->role_id);
        Session::put('username', $user->username);
        Session::put('user_email', $user->email);
        Session::put('first_name', $user->first_name);
        Session::put('last_name', $user->last_name);
        Session::put('user_photo', $user->photo);
    }

    public function promotion(Request $request){
        //try {
            $user = user::where('id',Session::get('user_id'))->first();

            $payment = Payment::where('user_id',$user->id)->first();
            if(!empty($payment) && $payment->payment_status=='Completed'){
                return redirect('all_project');
            }
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
        //try {
            $user = User::where('users.id',Session::get('user_id'))
                ->leftJoin('user_shipments','user_shipments.user_id','=','users.id')
                ->first();
            if($request->ajax()) {
                $returnHTML = View::make('user.profile',compact('user'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.profile',compact('user'));
        /*}
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'profile', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }

    public function profileEdit(Request $request)
    {
        $user = User::where('users.id',Session::get('user_id'))
            ->select('users.*','user_shipments.shipment_date')
            ->leftJoin('user_shipments','user_shipments.user_id','=','users.id')
            ->first();
        if($request->ajax()) {
            $returnHTML = View::make('user.profile-edit',compact('user'))->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.profile-edit',compact('user'));
    }
    public function resetPassword()
    {
        $user = User::where('users.id',Session::get('user_id'))->first();
        return view('user.reset-password',compact('user'));
    }

    public function profileUpdate(Request $request){
        //try {
            $user = User::where('id',$request->user_id)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
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

    public function addUser(Request $request)
    {
        $user = User::where('users.id',Session::get('user_id'))->first();
        Auth::logout();

        return redirect()->route('registration',['token'=>base64_encode($user->email)]);
    }

    public function storeNewUser(Request $request){
        //try {
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

            return ['status' => 200, 'reason' => 'New user created successfully'];
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'storeNewUser', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }
}
