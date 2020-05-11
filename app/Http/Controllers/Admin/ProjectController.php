<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use app\Models\Project;
use app\Common;
use app\SendMails;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(Request $request){
        try{
            $projects = Project::select('projects.*','user_projects.user_id')
                ->where('status','!=','deleted')
                ->get();
            if($request->ajax()) {
                $returnHTML = View::make('admin.project.all_project',compact('projects'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.project.all_project',compact('projects'));
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'index', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
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

    public function edit(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            if($request->ajax()) {
                $returnHTML = View::make('admin.project.edit_project',compact('project'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.project.edit_project',compact('project'));
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'edit', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function update(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->name = $request->name;
            $project->fabrication = $request->fabrication;
            $project->color = $request->color;
            $project->quantity = $request->quantity;
            $project->size_range = $request->size_range;
            $project->created_by = $user->id;
            $project->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'update', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateStatus(Request $request){
        try{
            $user = Auth::user();
            $project = Project::where('id',$request->project_id)->first();
            $project->status = $request->status;
            return ['status'=>200, 'reason'=>'Project made '.$request->status.' successfully'];
        }
        catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ProjectController', 'updateStatus', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
