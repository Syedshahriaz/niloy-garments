<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Common;
use App\SendMails;
use Auth;
use Session;

class AdminController extends Controller
{
    public function __construct()
    {
        //
    }

    public function login(){
        return view('auth.admin_login');
    }

    public function postLogin(Request $request)
    {
        $result = Auth::attempt([
            'email' => trim($request->email),
            'password' => $request->password,
            'role' => 2,
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
    }

    public function logout()
    {
        Auth::logout();

        Session::forget('user_id');
        Session::forget('unique_id');
        Session::forget('role');
        Session::forget('username');
        Session::forget('user_email');
        Session::forget('first_name');
        Session::forget('last_name');

        return redirect('admin/login');
    }

    public function index(Request $request)
    {
        try {
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            return redirect('admin/users');

        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'AdminController', 'index', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
