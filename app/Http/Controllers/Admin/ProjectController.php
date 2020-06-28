<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskTitle;
use App\Models\UserProjectTask;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request){
        try{
            $projects = Project::with('tasks')
                ->where('status','!=','deleted')
                ->get();
            $task_titles = TaskTitle::where('status','!=','deleted')
                ->get();
            if($request->ajax()) {
                $returnHTML = View::make('admin.project.all_project',compact('projects','task_titles'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.project',compact('projects','task_titles'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'index', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function create(Request $request){
        try{
            if($request->ajax()) {
                $returnHTML = View::make('admin.project.create_project')->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.project.create_project');
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'index', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function store(Request $request){
        try{
            $user = Auth::user();
            $project = NEW Project();
            $project->name = $request->name;
            $project->fabrication = $request->fabrication;
            $project->color = $request->color;
            $project->quantity = $request->quantity;
            $project->size_range = $request->size_range;
            $project->created_by = $user->id;
            $project->save();
            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'store', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getProjectAjax(Request $request){
        try{
            $project = Project::where('id',$request->project_id)->first();
            return ['status'=>200, 'reason'=>'', 'project'=>$project];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'getProjectAjax', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProject(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->name = $request->name;
            $project->sub_title = $request->sub_title;
            $project->fabrication = $request->fabrication;
            $project->color = $request->color;
            $project->quantity = $request->quantity;
            $project->size_range = $request->size_range;
            $project->updated_by = $user->id;
            $project->updated_at = date('Y-m-d');
            $project->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateProject', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProjectStatus(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->status = $request->status;
            $project->updated_at = date('Y-m-d');
            return ['status'=>200, 'reason'=>'Project made '.$request->status.' successfully'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateStatus', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateTaskTitle(Request $request){
        try{
            $user = Auth::user();
            $task = Task::where('id',$request->task_id)->first();
            $task->rule = $request->rule_name;
            $task->updated_at = date('Y-m-d');
            $task->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateTaskTitle', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateTaskRule(Request $request){
        try{
            $user = Auth::user();
            $task = Task::where('id',$request->task_id)->first();
            $task->rule = $request->rule_name;
            $task->updated_at = date('Y-m-d');
            $task->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateTaskRule', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateTaskStatus(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->status = $request->status;
            return ['status'=>200, 'reason'=>'Project made '.$request->status.' successfully'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateTaskStatus', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function unlockProjectTask(Request $request){
        try{
            $project_task = UserProjectTask::where('id',$request->project_task_id)->first();
            if($project_task->delivery_date_update_count != 0){
                $project_task->delivery_date_update_count = 1;
            }
            $project_task->save();
            return ['status'=>200, 'reason'=>'Project task unlocked successfully'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'unlockProjectTask', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
