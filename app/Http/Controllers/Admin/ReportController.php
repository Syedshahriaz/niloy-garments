<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Payment;
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

    public function offerPurchaseReport(Request $request)
    {
        try{
            $year = date('Y');
            if($request->year != ''){
                $year = $request->year;
            }
            $week_array = $this->getWeekArray($year);

            foreach($week_array as $key=>$week){
                $start_date = $week['start_date'].' 00:00:01';
                $end_date = $week['end_date'].' 23:59:59';

                $offer_1_purchases = Payment::select('user_payments.*')
                    ->join('user_shipments','user_shipments.user_id','=','user_payments.user_id')
                    ->whereBetween('user_payments.created_at',[$start_date, $end_date])
                    ->where('user_shipments.has_ofer_1',1)
                    ->count();
                $offer_2_purchases = Payment::select('user_payments.*')
                    ->join('user_shipments','user_shipments.user_id','=','user_payments.user_id')
                    ->whereBetween('user_payments.created_at',[$start_date, $end_date])
                    ->where('user_shipments.has_ofer_2',1)
                    ->count();

                $week_array[$key]['offer_1_purchases'] = $offer_1_purchases;
                $week_array[$key]['offer_2_purchases'] = $offer_2_purchases;
            }

            //echo "<pre>"; print_r($week_array); echo "</pre>"; exit();

            return view('admin.reports.report_by_offer_purchase',compact('year','week_array'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'offerPurchaseReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
        return back();
        }
    }

    private function getWeekArray($year){
        $start_date = $year.'-01-01';
        $end_date = $year.'-12-31';
        $end_date1 = date('Y-m-d', strtotime($end_date.' + 6 days'));

        $week_array = [];
        for($date = $start_date; $date <= $end_date1; $date = date('Y-m-d', strtotime($date. ' + 7 days')))
        {
            $date_range = $this->getWeekDates($date, $start_date, $end_date);
            $array_index = date('F d',strtotime($date_range['start_date'])).'-'.date('F d',strtotime($date_range['end_date']));
            //array_push($week_array,$date_range);
            $week_array[$array_index] = $date_range;
        }
        return $week_array;
    }

    private function getWeekDates($date, $start_date, $end_date)
    {
        $week =  date('W', strtotime($date));
        $year =  date('Y', strtotime($date));
        $from = date("Y-m-d", strtotime("{$year}-W{$week}+1")); //Returns the date of monday in week
        if($from < $start_date) $from = $start_date;
        $to = date("Y-m-d", strtotime("{$year}-W{$week}-6"));   //Returns the date of sunday in week
        if($to > $end_date) $to = $end_date;
        $date_range['start_date'] = $from;
        $date_range['end_date'] = $to;
        return $date_range;
    }
}
