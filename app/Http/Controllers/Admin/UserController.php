<?php

namespace App\Http\Controllers\Admin;

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

            $users = User::select('users.*', 'user_shipments.shipment_date')
                ->leftJoin('user_shipments', 'user_shipments.user_id', '=', 'users.id')
                ->where('users.parent_id',0)
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

            $buyer = Buyer::where('user_id',$user_id)->first();

            if ($request->ajax()) {
                $returnHTML = View::make('admin.user.dashboard',
                    compact('user_id','projects','buyer'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.user.dashboard',compact('user_id','projects','buyer'));
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

            $user = User::where('id', $request->user_id)->first();
            $user->status  = $request->status;
            $user->updated_by  = $admin_user->id;
            $user->updated_at  = date('Y-m-d h:i:s');
            if($request->status=='deleted'){
                $user->deleted_at  = date('Y-m-d h:i:s');
            }
            $user->save();

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
            $user = User::where('id',$request->user_id)->first();

            $email_to = [$user->email];
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
