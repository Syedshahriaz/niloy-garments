<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index(Request $request){
        try{
            $settings = Setting::first();
            if($request->ajax()) {
                $returnHTML = View::make('admin.settings',compact('settings'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings',compact('settings'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'index', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function update(Request $request){
        try{
            $user = Auth::user();
            $setting = Setting::first();
            $setting->message_to_user = $request->message_to_user;
            $setting->updated_at = date('Y-m-d h:i:s');
            $setting->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'update', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
