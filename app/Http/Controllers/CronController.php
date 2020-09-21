<?php

namespace App\Http\Controllers;

use App\SMS;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserShipment;
use App\Models\UserProject;
use App\Models\UserProjectTask;
use App\Models\User;
use App\Common;
use App\SendMails;
use Auth;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function sendTaskWarningEmail(Request $request){
        try{
            $result = Common::sendTaskWarningEmail();
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'CronController', 'sendTaskWarningEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function sendSubscriptionRenewWarningEmail(Request $request){
        try{
            $result = Common::sendTaskWarningEmail();
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'CronController', 'sendSubscriptionRenewWarningEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function sendBirthdayWish(Request $request){
        try{
            $month = date("m", strtotime("+ 1 day")); // getting tomorrow month
            $day = date("d", strtotime("+ 1 day")); // getting tomorrow day

            $users = User::select('users.id','users.phone')
                ->join('user_shipments','user_shipments.user_id','=','users.id')
                ->whereRaw('MONTH(shipment_date) = '.$month)
                ->whereRaw('DAY(shipment_date) = '.$day)
                ->get();

            foreach($users as $user){
                $message_body = 'May your birthday be as beautiful, wonderful as you are. ';
                $message_body.='I pray to God that each candle on the cake convert into wish and May all of them come true. ';
                $message_body.='Happy Birthday!';

                $response = SMS::sendSingleSms($user->phone,$message_body);

                /*
                 * Store sms sending record
                 * */
                $result = Common::storeSmsRecord($user->id, $message_body);
            }

            return $response;
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'CronController', 'sendSubscriptionRenewWarningEmail', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

}
