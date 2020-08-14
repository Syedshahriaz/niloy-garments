<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function allReport(Request $request)
    {
        try{
            return view('admin.reports.sample_report');
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'allReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function genderReport(Request $request)
    {
        try{
            $male_user = User::where('gender','Male')
                ->whereIn('status',['active','pending'])
                ->count();
            $female_user = User::where('gender','Female')
                ->whereIn('status',['active','pending'])
                ->count();
            return view('admin.reports.report_by_gender',compact('male_user','female_user'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'genderReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
        return back();
        }
    }

    public function professionReport(Request $request)
    {
        try{
            $users = DB::table('users')
                ->select('professions.title as profession', DB::raw('count(*) as total_user'))
                ->leftJoin('professions','professions.id','=','users.profession')
                ->whereIn('users.status',['active','pending'])
                ->groupBy('users.profession')
                ->get();
            //echo "<pre>"; print_r($users); echo "</pre>"; exit();

            return view('admin.reports.report_by_profession',compact('users'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'professionReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
        return back();
        }
    }
}
