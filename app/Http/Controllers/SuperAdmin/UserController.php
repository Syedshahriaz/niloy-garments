<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\GroupPermission;
use App\Models\User;
use App\Common;
use App\SendMails;
use App\SMS;
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

            $users = User::select('users.*')
                ->where('users.role',2)
                ->where('users.status', '!=', 'deleted')
                ->orderBy('users.id', 'ASC')
                ->get();

            $permissions = Permission::get()->groupBy('type')->toArray();

            if ($request->ajax()) {
                $returnHTML = View::make('super_admin.user.all_user', compact('users','permissions'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }

            return view('super_admin.user.all_user', compact('users','permissions'));
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userList', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function editUser(Request $request)
    {
        try {
            $user = User::with('permissions')
                ->select('users.*')
                ->where('id',$request->user_id)
                ->first();

            return [ 'status' => 200, 'reason' => '', 'user'=>$user];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'userList', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $permissions = $request->permission;
            GroupPermission::where('user_id',$request->user_id)->delete();

            if(count($permissions) != 0){
                foreach($permissions as $permission){
                    $upr = NEW GroupPermission();
                    $upr->user_id = $request->user_id;
                    $upr->permission_id = $permission;
                    $upr->save();
                }
            }

            return [ 'status' => 200, 'reason' => 'Successfully Updated' ];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'UserController', 'updateUser', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
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
}
