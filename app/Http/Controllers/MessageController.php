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
        if($request->ajax()) {
            $returnHTML = View::make('user.message',compact('user'))->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.message',compact('user'));
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
                $message->save();

                $message_id = $message->id;
            }
            else{
                $message = Message::where('id',$message_id)->first();
                $message->has_new_message = 1;
                $message->save();
            }
            /*
             * Store message details
             * */
            if($request->message !=''){
                $messageDetails = NEW MessageDetails();
                $messageDetails->message_id = $message_id;
                $messageDetails->type = 'sent';
                $messageDetails->description = $request->message;
                $messageDetails->save();
            }

            if($request->hasFile('message_file')){
                $file = $request->File('message_file');
                $extension = $file->getClientOriginalExtension();
                $file_name = md5(rand(10,10000)).time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/messages');
                $file->move($destinationPath, $file_name);

                $photo_path = 'uploads/messages/'.$file_name;

                $messageDetails = NEW MessageDetails();
                $messageDetails->message_id = $message_id;
                $messageDetails->type = 'sent';
                $messageDetails->file_path = $photo_path;
                $messageDetails->save();
            }

            return [ 'status' => 200, 'reason' => 'Message stored successfully'];

        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'MessageController', 'store', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
