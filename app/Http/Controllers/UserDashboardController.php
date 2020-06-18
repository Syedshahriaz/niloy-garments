<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\Buyer;
use App\Models\User;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use View;

class UserDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            if ($request->u_id == '') {
                $user_id = Session::get('user_id');
            } else {
                $user_id = $request->u_id;
            }

            $shipment = UserShipment::where('user_id', $user_id)->first();
            if (empty($shipment)) {
                return redirect('select_shipment/'.$user_id);
            }
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
                $returnHTML = View::make('user.dashboard',
                    compact('user_id','projects','buyer'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('user.dashboard',compact('user_id','projects','buyer'));
            //echo "<pre>"; print_r($projects); echo "</pre>";
        } catch (\Exception $e) {
            /*SendMails::sendErrorMail($e->getMessage(), null, 'UserDashboardController', 'dashboard', $e->getLine(),
                $e->getFile(), '', '', '', '');*/
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function saveBuyer(Request $request)
    {
        try {
            $buyer = Buyer::firstOrNew(['id' => $request->buyer_id]);
            $buyer->user_id  = $request->user_id;
            $buyer->buyer_name  = $request->buyer_name;
            $buyer->buyer_email  = $request->buyer_email;
            $buyer->buyer_phone  = $request->buyer_phone;
            $buyer->buying_agent_name  = $request->buying_agent_name;
            $buyer->buying_agent_email  = $request->buying_agent_email;
            $buyer->buying_agent_phone  = $request->buying_agent_phone;
            $buyer->address  = $request->address;
            $buyer->save();

            return ['status'=>200, 'reason'=>'Successfully saved','buyer'=>$buyer];
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'storeBuyer', 'dashboard', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
