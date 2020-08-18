<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Analytics;
use Spatie\Analytics\Period;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
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

    public function downloadGenderReportExcel(Request $request)
    {
        try{
            $male_user = User::where('gender','Male')
                ->whereIn('status',['active','pending'])
                ->count();
            $female_user = User::where('gender','Female')
                ->whereIn('status',['active','pending'])
                ->count();

            //object of the Spreadsheet class to create the excel data
            $spreadsheet = new Spreadsheet();

            //get current active sheet(first sheet)
            $sheet = $spreadsheet->getActiveSheet();

            //set default font
            $spreadsheet->getDefaultStyle()
                ->getFont()
                ->setName("Arial")
                ->setSize(10);

            /**
             * Start Heading package with set merge, text center,
             */
            //Heading Title Venessa  Bangladesh  Limited
            $spreadsheet->getActiveSheet()
                ->setCellValue('A1', "Total Purchase by Gender");

            //Merge Heading
            $spreadsheet->getActiveSheet()
                ->mergeCells("A1:H1");

            //set font style
            $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18)->setBold(true);

            //set Cell Allignment
            $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //set columns width and Height
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);

            $z = 200;
            for ($i = 1; $i < $z; $i++) {
                $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
            }


            /**
             * Received Quantity Header
             */

            $spreadsheet->getActiveSheet()
                ->setCellValue('A3', 'Total Customer');


            $spreadsheet->getActiveSheet()
                ->setCellValue('B3', 'Total Male Customer');

            $spreadsheet->getActiveSheet()
                ->setCellValue('C3', 'Total Female Customer');

            /**
             * Invoice data Array
             */

            $received_data_header_cell_number = 1;
            $received_data_header_row_number = 4;

            $total_purchase = $male_user+$female_user;


            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $total_purchase);

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $male_user);

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $female_user);


            /**
             * Footer Row
             */


            /************************/

            //make object of the Xlsx class to save the excel file
            $writer = new Xls($spreadsheet);


            $filename = 'purchase_by_age_'.date('Y-m-d-H-i-s') . ".xls";


            // We'll be outputting an excel file
            header('Content-type: application/vnd.ms-excel');

            // It will be called file.xls
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Write file to the browser
            $writer->save('php://output');

        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'downloadGenderReportExcel', $e->getLine(), $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.z
            return back();
        }


    }

    public function locationReport(Request $request)
    {
        try{
            $country = Analytics::performQuery(Period::days(14),'ga:sessions',  ['dimensions'=>'ga:country','sort'=>'-ga:country']);
            $locations= collect($country['rows'] ?? [])->map(function (array $dateRow) {
                return [
                    'country' =>  $dateRow[0],
                    'sessions' => (int) $dateRow[1],
                ];
            });

            return view('admin.reports.report_by_location',compact('locations'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'offerPurchaseReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function downloadLocationReportExcel(Request $request)
    {
        try{
            $country = Analytics::performQuery(Period::days(14),'ga:sessions',  ['dimensions'=>'ga:country','sort'=>'-ga:country']);
            $locations= collect($country['rows'] ?? [])->map(function (array $dateRow) {
                return [
                    'country' =>  $dateRow[0],
                    'sessions' => (int) $dateRow[1],
                ];
            });

            //object of the Spreadsheet class to create the excel data
            $spreadsheet = new Spreadsheet();

            //get current active sheet(first sheet)
            $sheet = $spreadsheet->getActiveSheet();

            //set default font
            $spreadsheet->getDefaultStyle()
                ->getFont()
                ->setName("Arial")
                ->setSize(10);

            /**
             * Start Heading package with set merge, text center,
             */
            //Heading Title Venessa  Bangladesh  Limited
            $spreadsheet->getActiveSheet()
                ->setCellValue('A1', "Total Visitor by Location");

            //Merge Heading
            $spreadsheet->getActiveSheet()
                ->mergeCells("A1:H1");

            //set font style
            $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18)->setBold(true);

            //set Cell Allignment
            $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //set columns width and Height
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);

            $z = 200;
            for ($i = 1; $i < $z; $i++) {
                $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
            }


            /**
             * Received Quantity Header
             */

            $spreadsheet->getActiveSheet()
                ->setCellValue('A3', 'Location');


            $spreadsheet->getActiveSheet()
                ->setCellValue('B3', 'Visitor');

            /**
             * Invoice data Array
             */

            $received_data_header_row_number = 4;

            $total_visitor = 0;
            foreach($locations as $key=>$location){
                $received_data_header_cell_number = 1;

                $total_visitor = $total_visitor+$location['sessions'];

                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $location['country']);

                $received_data_header_cell_number = $received_data_header_cell_number + 1;
                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $location['sessions']);

                $received_data_header_row_number++;
            }

            /**
             * Footer Row
             */
            $received_data_header_cell_number = 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, 'Total');

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $total_visitor);
            /************************/

            // Making total purchase column bold
            $spreadsheet->getActiveSheet()->getStyle("A" . $received_data_header_row_number)->getFont()->setBold(true);

            //make object of the Xlsx class to save the excel file
            $writer = new Xls($spreadsheet);


            $filename = 'visitor_by_location_'.date('Y-m-d-H-i-s') . ".xls";

            // We'll be outputting an excel file
            header('Content-type: application/vnd.ms-excel');

            // It will be called file.xls
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Write file to the browser
            $writer->save('php://output');

        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'downloadLocationReportExcel', $e->getLine(), $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.z
            return back();
        }

    }

    public function ageReport(Request $request)
    {
        try{
            $analyticsData = Analytics::performQuery(Period::days(14),'ga:sessions',
                ['dimensions' => 'ga:userGender,ga:userAgeBracket']
            );
            $ages= collect($country['rows'] ?? [])->map(function (array $dateRow) {
                return [
                    'country' =>  $dateRow[0],
                    'sessions' => (int) $dateRow[1],
                ];
            });

            //echo "<pre>"; print_r($ages); echo "</pre>"; exit();

            return view('admin.reports.report_by_age',compact('ages'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'offerPurchaseReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }
    }

    public function downloadAgeReportExcel(Request $request)
    {
        try{
            $analyticsData = Analytics::performQuery(Period::days(14),'ga:sessions',
                ['dimensions' => 'ga:userGender,ga:userAgeBracket']
            );
            $ages= collect($country['rows'] ?? [])->map(function (array $dateRow) {
                return [
                    'country' =>  $dateRow[0],
                    'sessions' => (int) $dateRow[1],
                ];
            });

            //object of the Spreadsheet class to create the excel data
            $spreadsheet = new Spreadsheet();

            //get current active sheet(first sheet)
            $sheet = $spreadsheet->getActiveSheet();

            //set default font
            $spreadsheet->getDefaultStyle()
                ->getFont()
                ->setName("Arial")
                ->setSize(10);

            /**
             * Start Heading package with set merge, text center,
             */
            //Heading Title Venessa  Bangladesh  Limited
            $spreadsheet->getActiveSheet()
                ->setCellValue('A1', "Total Visitor by Age");

            //Merge Heading
            $spreadsheet->getActiveSheet()
                ->mergeCells("A1:H1");

            //set font style
            $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18)->setBold(true);

            //set Cell Allignment
            $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //set columns width and Height
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);

            $z = 200;
            for ($i = 1; $i < $z; $i++) {
                $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
            }


            /**
             * Received Quantity Header
             */

            $spreadsheet->getActiveSheet()
                ->setCellValue('A3', 'Age');


            $spreadsheet->getActiveSheet()
                ->setCellValue('B3', 'Visitor');

            /**
             * Invoice data Array
             */

            $received_data_header_row_number = 4;

            $total_visitor = 0;
            foreach($ages as $key=>$age){
                $received_data_header_cell_number = 1;

                $total_visitor = $total_visitor+$age['sessions'];

                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $age['country']);

                $received_data_header_cell_number = $received_data_header_cell_number + 1;
                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $age['sessions']);

                $received_data_header_row_number++;
            }

            /**
             * Footer Row
             */
            $received_data_header_cell_number = 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, 'Total');

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $total_visitor);
            /************************/

            // Making total purchase column bold
            $spreadsheet->getActiveSheet()->getStyle("A" . $received_data_header_row_number)->getFont()->setBold(true);

            //make object of the Xlsx class to save the excel file
            $writer = new Xls($spreadsheet);


            $filename = 'visitor_by_age_'.date('Y-m-d-H-i-s') . ".xls";

            // We'll be outputting an excel file
            header('Content-type: application/vnd.ms-excel');

            // It will be called file.xls
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Write file to the browser
            $writer->save('php://output');

        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'downloadLocationReportExcel', $e->getLine(), $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.z
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

            return view('admin.reports.report_by_profession',compact('users'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'professionReport', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
        return back();
        }
    }

    public function downloadProfessionReportExcel(Request $request)
    {
        try{
            $users = DB::table('users')
                ->select('professions.title as profession', DB::raw('count(*) as total_user'))
                ->leftJoin('professions','professions.id','=','users.profession')
                ->whereIn('users.status',['active','pending'])
                ->groupBy('users.profession')
                ->get();

            //object of the Spreadsheet class to create the excel data
            $spreadsheet = new Spreadsheet();

            //get current active sheet(first sheet)
            $sheet = $spreadsheet->getActiveSheet();

            //set default font
            $spreadsheet->getDefaultStyle()
                ->getFont()
                ->setName("Arial")
                ->setSize(10);

            /**
             * Start Heading package with set merge, text center,
             */
            //Heading Title Venessa  Bangladesh  Limited
            $spreadsheet->getActiveSheet()
                ->setCellValue('A1', "Total Purchase by Profession");

            //Merge Heading
            $spreadsheet->getActiveSheet()
                ->mergeCells("A1:H1");

            //set font style
            $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18)->setBold(true);

            //set Cell Allignment
            $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //set columns width and Height
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);

            $z = 200;
            for ($i = 1; $i < $z; $i++) {
                $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
            }


            /**
             * Received Quantity Header
             */

            $spreadsheet->getActiveSheet()
                ->setCellValue('A3', 'Profession');


            $spreadsheet->getActiveSheet()
                ->setCellValue('B3', 'Total Customer');

            /**
             * Invoice data Array
             */

            $received_data_header_row_number = 4;

            $grand_total_user = 0;
            foreach($users as $key=>$user){
                $received_data_header_cell_number = 1;

                $grand_total_user = $grand_total_user+$user->total_user;

                if($user->profession != ''){
                    $profession_title = $user->profession;
                }
                else{
                    $profession_title = 'No Profession';
                }

                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $profession_title);

                $received_data_header_cell_number = $received_data_header_cell_number + 1;
                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $user->total_user);

                $received_data_header_row_number++;
            }

            /**
             * Footer Row
             */
            $received_data_header_cell_number = 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, 'Total');

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $grand_total_user);
            /************************/

            // Making total purchase column bold
            $spreadsheet->getActiveSheet()->getStyle("A" . $received_data_header_row_number)->getFont()->setBold(true);

            //make object of the Xlsx class to save the excel file
            $writer = new Xls($spreadsheet);


            $filename = 'purchase_by_profession_'.date('Y-m-d-H-i-s') . ".xls";


            // We'll be outputting an excel file
            header('Content-type: application/vnd.ms-excel');

            // It will be called file.xls
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Write file to the browser
            $writer->save('php://output');

        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'downloadProfessionReportExcel', $e->getLine(), $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.z
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

    public function downloadOfferPurchaseReportExcel(Request $request)
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

            //object of the Spreadsheet class to create the excel data
            $spreadsheet = new Spreadsheet();

            //get current active sheet(first sheet)
            $sheet = $spreadsheet->getActiveSheet();

            //set default font
            $spreadsheet->getDefaultStyle()
                ->getFont()
                ->setName("Arial")
                ->setSize(10);

            /**
             * Start Heading package with set merge, text center,
             */
            //Heading Title Venessa  Bangladesh  Limited
            $spreadsheet->getActiveSheet()
                ->setCellValue('A1', "Total Weekly Purchase Offer for ".$year);

            //Merge Heading
            $spreadsheet->getActiveSheet()
                ->mergeCells("A1:H1");

            //set font style
            $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18)->setBold(true);

            //set Cell Allignment
            $spreadsheet->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //set columns width and Height
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);

            $z = 200;
            for ($i = 1; $i < $z; $i++) {
                $spreadsheet->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
            }


            /**
             * Received Quantity Header
             */

            $spreadsheet->getActiveSheet()
                ->setCellValue('A3', 'Week');
            $spreadsheet->getActiveSheet()
                ->setCellValue('B3', 'Green Offer Purchase');
            $spreadsheet->getActiveSheet()
                ->setCellValue('C3', 'Red Offer Purchase');
            $spreadsheet->getActiveSheet()
                ->setCellValue('D3', 'Total Purchase');

            /**
             * Invoice data Array
             */

            $received_data_header_row_number = 4;

            $total_purchase = 0;
            $grant_total_purchase = 0;
            foreach($week_array as $key=>$week){
                $received_data_header_cell_number = 1;

                $total_purchase = $week['offer_1_purchases']+$week['offer_2_purchases'];
                $grant_total_purchase = $grant_total_purchase + $total_purchase;

                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $key);

                $received_data_header_cell_number = $received_data_header_cell_number + 1;
                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $week['offer_1_purchases']);

                $received_data_header_cell_number = $received_data_header_cell_number + 1;
                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $week['offer_2_purchases']);

                $received_data_header_cell_number = $received_data_header_cell_number + 1;
                $spreadsheet->getActiveSheet()
                    ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $total_purchase);

                $received_data_header_row_number++;
            }

            /**
             * Footer Row
             */
            $received_data_header_cell_number = 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, 'Total');

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, '');

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, '');

            $received_data_header_cell_number = $received_data_header_cell_number + 1;
            $spreadsheet->getActiveSheet()
                ->setCellValue($this->getCellName($received_data_header_cell_number) . $received_data_header_row_number, $grant_total_purchase);
            /************************/

            // Making total purchase column bold
            $spreadsheet->getActiveSheet()->getStyle("A" . $received_data_header_row_number)->getFont()->setBold(true);

            //make object of the Xlsx class to save the excel file
            $writer = new Xls($spreadsheet);


            $filename = 'weekly_purchase_by_offer_'.date('Y-m-d-H-i-s') . ".xls";


            // We'll be outputting an excel file
            header('Content-type: application/vnd.ms-excel');

            // It will be called file.xls
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            // Write file to the browser
            $writer->save('php://output');

        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'downloadOfferPurchaseReportExcel', $e->getLine(), $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.z
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

    public function analyticsTest(Request $request)
    {
        //try{
            //retrieve visitors and pageview data for the current day and the last seven days
                //$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        $analyticsData = Analytics::performQuery(Period::days(7), 'ga:users,ga:sessions',
            [
                'dimensions' => 'ga:userGender,ga:userAgeBracket',
            ]
        );

        $country = Analytics::performQuery(Period::days(14),'ga:sessions',  ['dimensions'=>'ga:country','sort'=>'-ga:sessions']);
        $result= collect($country['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'country' =>  $dateRow[0],
                'sessions' => (int) $dateRow[1],
            ];
        });
        /* $data['country'] = $result->pluck('country'); */
        /* $data['country_sessions'] = $result->pluck('sessions'); */
            echo "<pre>"; print_r($result); echo "</pre>";

            //return view('admin.reports.report_by_offer_purchase',compact('year','week_array'));
        /*}
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/ReportController', 'analyticsTest', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return back();
        }*/
    }

    public function getCellName($number)
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($number);
    }

}
