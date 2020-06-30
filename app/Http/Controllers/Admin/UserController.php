<?php

namespace App\Http\Controllers\Admin;

use App\Models\TaskTitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\Buyer;
use App\Models\User;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class UserController extends Controller
{

    public function userList(Request $request)
    {
        try {
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }

            $users = User::with('running_task','last_task')
                ->select('users.*', 'user_shipments.shipment_date')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->where('users.role',3)
                ->where('users.status', '!=', 'deleted')
                ->orderBy('users.id', 'ASC')
                ->get();

            if ($request->ajax()) {
                $returnHTML = View::make('admin.user.all_user', compact('users'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }

            return view('admin.user.all_user', compact('users'));
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userList', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
    public function dashboard(Request $request)
    {
        try {
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }

            $user_id = $request->u_id;

            /*$shipment = UserShipment::where('user_id', $user_id)->first();
            if (empty($shipment)) {
                return redirect('select_shipment/'.$user_id);
            }*/
            $projects = UserProject::with('tasks','running_task','last_task')
                ->select('projects.*', 'tasks.title', 'tasks.days_to_add', 'user_projects.id as user_project_id')
                ->leftJoin('projects', 'projects.id', '=', 'user_projects.project_id')
                ->leftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
                ->where('user_projects.user_id', $user_id)
                ->where('projects.status', 'active')
                ->groupBy('projects.id')
                ->get();

            $task_titles = TaskTitle::where('status','!=','deleted')
                ->get();

            $buyer = Buyer::where('user_id',$user_id)->first();

            if ($request->ajax()) {
                $returnHTML = View::make('admin.user.dashboard',
                    compact('user_id','projects','task_titles','buyer'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.user.dashboard',compact('user_id','projects','task_titles','buyer'));
            //echo "<pre>"; print_r($projects); echo "</pre>";
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'dashboard', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $admin_user = Auth::user();

            $userIds = explode(',',$request->user_id);

            if($request->status=='deleted'){
                $deleted_at  = date('Y-m-d h:i:s');
            }
            else{
                $deleted_at = NULL;
            }

            User::whereIn('id', $userIds)
            ->update(
                [
                    'status' => $request->status,
                    'updated_by' => $admin_user->id,
                    'updated_at' => date('Y-m-d h:i:s'),
                    'deleted_at' => $deleted_at,
                ]
            );

            return ['status'=>200, 'reason'=>'Status Successfully updated'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'updateStatus', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function sendUserEmail(Request $request)
    {
        try {
            $userIds = explode(',',$request->user_id);
            $user_emails = User::select('email')
                ->whereIN('id',$userIds)
                ->pluck('email')
                ->toArray();

            $email_to = $user_emails;
            $email_cc = [];
            $email_bcc = [];

            $emailData['from_email'] = Common::FROM_EMAIL;
            $emailData['from_name'] = Common::FROM_NAME;
            $emailData['email'] = $email_to;
            $emailData['email_cc'] = $email_cc;
            $emailData['email_bcc'] = $email_bcc;
            $emailData['subject'] = 'Niloy Garments-'.$request->subject;

            $emailData['bodyMessage'] = $request->message;;

            $view = 'emails.user_custom_email';

            $result = SendMails::sendMail($emailData, $view);

            return ['status'=>200, 'reason'=>'Status Successfully updated'];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/UserController', 'sendUserEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
