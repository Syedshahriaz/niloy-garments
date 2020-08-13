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

}
