<?php

namespace App;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ErrorLog;
use Carbon\Carbon;
use Session;
use Auth;
use DB;

/**
 * Class Common, this class is to use project common functions
 *
 * @package App
 */
class Common
{
    const SITE_TITLE = 'Niloy Garments';
    const DOMAIN_NAME = 'tna.ownenterprise.com';
    const SITE_URL = 'http://tna.ownenterprise.com';
    const FROM_EMAIL = 'mail2technerd@gmail.com';
    const FROM_NAME = 'Niloy Garments';

    const VALID_IMAGE_EXTENSIONS = ['jpg','JPG','jpeg','JPEG'];
    const VALID_FILE_EXTENSIONS = ['jpg','JPG','jpeg','JPEG','png','PNG','svg','doc','docx','odt','xls','xlsx','ods','pdf'];

    public static function is_admin_login(){
        if (Session::get('user_id') && Session::get('role')==2) {
            return 1;
        }
        return 0;
    }

    public static function send7dayWarningEmail($email,$task){
        /*
         * Send task 7 day before complete warning email
         */
        $today = date('Y-m-d');

        $email_to = $email;
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['task'] = $task;
        $emailData['subject'] = 'Niloy Garments- Project task completion warning';

        $emailData['bodyMessage'] = '';

        $view = 'emails.project_task_complete_7day_warning_email';

        $result = SendMails::sendMail($emailData, $view);
        return $result;
    }

    public static function sendPastDayWarningEmail($email,$task){
        /*
         * Send task past day complete warning email
         */
        $today = date('Y-m-d');

        $email_to = $email;
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['task'] = $task;
        $emailData['subject'] = 'Niloy Garments- Project task completion warning';

        $emailData['bodyMessage'] = '';

        $view = 'emails.project_task_complete_past_warning_email';

        $result = SendMails::sendMail($emailData, $view);
        return $result;
    }

    public static function saveErrorLog($method,$line_number,$file_path,$message,$object,$type,$screenshot,$page_url,$argument,$prefix,$domain){

        /*Save error to database*/
        try{
            $errorLog = NEW ErrorLog();
            $errorLog->method_name = $method;
            $errorLog->line_number = $line_number;
            $errorLog->file_path = $file_path;
            $errorLog->exception_message = $message;
            $errorLog->object = $object;
            $errorLog->type = $type;
            $errorLog->screenshot = $screenshot;
            $errorLog->page_url = $page_url;
            $errorLog->arguments = $argument;
            $errorLog->prefix = $prefix;
            $errorLog->domain = $domain;
            $errorLog->save();
            return $errorLog->error_log_id;
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /*
    | Get Month From Date
    */
    public static function getMonth($time)
    {
        try{
            $date = new Carbon( $time );
            return $date->month;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    /*
    | Get Year From Date
    */
    public static function getYear($time)
    {
        try{
            $date = new Carbon( $time );
            return $date->year;
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public static function generaterandomNumber($length){
        $min = pow(10,$length);
        $max = pow(10,$length+1);
        $value = rand($min, $max);
        return $value;
    }

    public static function generaterandomString($length){
        $string = substr(md5(uniqid(mt_rand(), true)), 0, $length);
        return $string;
    }

    public static function generateUniqueNumber($number){
        $number_length = strlen($number);
        $leading_zero = 9-$number_length;
        for($i=$leading_zero; $i>0; $i--){
            $number = '0'.$number;
        }

        $insertion = "-";
        $index1 = 6;
        $index2 = 3;
        $number = substr_replace($number, $insertion, $index1, 0);
        $number = substr_replace($number, $insertion, $index2, 0);

        return $number;
    }

    public static function isValidImageExtension($image_file){
        $extension = $image_file->getClientOriginalExtension();
        if(in_array($extension, Common::VALID_IMAGE_EXTENSIONS)){
            return 1;
        }
        else{
            return 0;
        }
    }

}//End
