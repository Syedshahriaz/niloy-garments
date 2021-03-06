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
            $month = date("m", strtotime("+ 30 day")); // getting next month
            $day = date("d", strtotime("+ 30 day")); // getting next month day

            $users = User::select('users.id','users.unique_id','users.username','users.phone','users.email','user_shipments.subscription_plan_id','user_payments.payment_date','subscription_plans.name as subscription_name','subscription_plans.year','subscription_plans.is_lifetime')
                ->join('user_shipments','user_shipments.user_id','=','users.id')
                ->join('user_payments','user_payments.user_id','=','users.id')
                ->join('subscription_plans','subscription_plans.id','=','user_shipments.subscription_plan_id')
                ->where('subscription_plans.is_lifetime',0)
                ->get();

            //echo "<pre>"; print_r($users); echo "</pre>"; exit();

            /*$users = User::select('users.id','users.unique_id','users.username','users.phone','users.email','user_payments.payment_date')
                ->join('user_payments','user_payments.user_id','=','users.id')
                ->whereRaw('MONTH(payment_date) = '.$month)
                ->whereRaw('DAY(payment_date) = '.$day)
                ->get();*/

            $response = 'No user found';

            foreach($users as $user){
                $expiry_date = date('Y-m-d', strtotime('+'.$user->year.' years', strtotime($user->payment_date)));
                $upcoming_date = date("Y-m-d", strtotime("+ 30 day")); // getting next month date

                if($upcoming_date == $expiry_date){
                    $email = [$user->email];

                    $email_to = $email;
                    $email_cc = [];
                    $email_bcc = [];

                    $emailData['from_email'] = Common::FROM_EMAIL;
                    $emailData['from_name'] = Common::FROM_NAME;
                    $emailData['email'] = $email_to;
                    $emailData['email_cc'] = $email_cc;
                    $emailData['email_bcc'] = $email_bcc;
                    $emailData['user'] = $user;
                    $emailData['expiry_date'] = $expiry_date;
                    $emailData['subject'] = Common::SITE_TITLE.'- Subscription renew warning';

                    $emailData['bodyMessage'] = '';

                    $view = 'emails.subscription_renew_warning_email';

                    $response = SendMails::sendMail($emailData, $view);
                }
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
