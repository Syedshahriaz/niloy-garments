<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageDetails;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use View;

class MessageController extends Controller
{
    public function message(Request $request)
    {
        $user = Auth::user();
        $message = Message::with('message_details')
            ->select('messages.*','user.username as user_name','user.photo as user_photo','admin.username as admin_name','admin.photo as admin_photo')
            ->join('users as user','user.id','=','messages.user_id')
            ->join('users as admin','admin.id','=','messages.admin_id')
            ->where('user_id',$user->id)
            ->first();
        if($request->ajax()) {
            $returnHTML = View::make('user.message',compact('user','message'))->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.message',compact('user','message'));
    }

    public function store(Request $request)
    {
        try{
            $message_id = $request->message_id;
            $admin_id = 3;
            if($message_id==''){
                $message = NEW Message();
                $message->user_id = $request->user_id;
                $message->admin_id = $admin_id;
                $message->updated_at = date('Y-m-d h:i:s');
                $message->save();

                $message_id = $message->id;
            }
            else{
                $message = Message::where('id',$message_id)->first();
                $message->has_new_message = 1;
                $message->updated_at = date('Y-m-d h:i:s');
                $message->save();
            }

            $photo_path = '';

            /*
             * Store message details
             * */
            $messageDetails = NEW MessageDetails();
            $messageDetails->message_id = $message_id;
            $messageDetails->type = 'sent';
            if($request->message !=''){
                $messageDetails->message = $request->message;
            }

            if($request->hasFile('message_file')){
                $file = $request->File('message_file');
                $extension = $file->getClientOriginalExtension();
                $file_name = md5(rand(10,10000)).time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/messages');
                $file->move($destinationPath, $file_name);

                $photo_path = 'uploads/messages/'.$file_name;

                $messageDetails->file_path = $photo_path;
            }
            $messageDetails->save();

            return [ 'status' => 200, 'reason' => 'Message stored successfully','photo_path'=>$photo_path];

        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'MessageController', 'store', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getUnreadMessage(Request $request)
    {
        try{
            $messages = MessageDetails::select('message_details.*','user.username as user_name','user.photo as user_photo','admin.username as admin_name','admin.photo as admin_photo')
                ->join('messages','messages.id','=','message_details.message_id')
                ->join('users as user','user.id','=','messages.user_id')
                ->join('users as admin','admin.id','=','messages.admin_id')
                ->where('messages.user_id',$request->user_id)
                ->where('type','received')
                ->where('is_read',0)
                ->get();

            return ['status'=>200, 'reason'=>'','messages'=>$messages];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'MessageController', 'store', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
