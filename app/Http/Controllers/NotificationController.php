<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use View;

class NotificationController extends Controller
{
    public function notifications(Request $request)
    {
        try{
            $user = Auth::user();
            if($request->nid !=''){
                $notifications = Common::getNotificationDetails($request->nid);

                /*
                 * Update notification read status
                 * */
                $affected = DB::table('notifications')
                        ->where('id', $request->nid)
                        ->update(['is_read' => 1]);
            }
            else{
                $notifications = Common::getNotifications($user->id);

                /*
                 * Update notification read status
                 * */
                $affected = DB::table('notifications')
                    ->where('user_id',$user->id)
                   ->orWhere('parent_id',$user->id)
                    ->update(['is_read' => 1]);
            }

            if($request->ajax()) {
                $returnHTML = View::make('user.notification',compact('user','notifications'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.notifications',compact('user','notifications'));
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'NotificationController', 'notifications', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
