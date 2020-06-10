<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\User;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class UserDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user_id = Session::get('user_id');
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

        if ($request->ajax()) {
            $returnHTML = View::make('user.dashboard',
                compact('projects'))->renderSections()['content'];
            return response()->json(array('status' => 200, 'html' => $returnHTML));
        }
        return view('user.dashboard',compact('projects'));
        //echo "<pre>"; print_r($projects); echo "</pre>";
    }
}
