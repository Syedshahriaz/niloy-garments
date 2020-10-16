<?php

namespace App;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Common;
use App\Models\ErrorLog;
use DB;

/**
 * Class Common, this class is to use project common functions
 *
 * @package App
 */
class SMS
{
    /*
     * To check the remaining SMS balance status of your account (Prepaid account),
     * you can use this API.
     * */
    public static function checkRemainingSmsBalance(){
        $postdata = array(
            'api_key' => env('SMS_API_KEY'),
            'api_secret' => env('SMS_API_SECRET'),
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/check-balance",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    /*
     * To check the individual campaign status, you can call this API.
     * */
    public static function checkCampaignStatus($campaign_uid){
        $postdata = array(
            'api_key' => env('SMS_API_KEY'),
            'api_secret' => env('SMS_API_SECRET'),
            'campaign_uid' => $campaign_uid,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/campaign-status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    /*
     * To check the individual SMS status, you can call this API.
     * */
    public static function checkSmsStatus($sms_uid){
        $postdata = array(
            'api_key' => env('SMS_API_KEY'),
            'api_secret' => env('SMS_API_SECRET'),
            'sms_uid' => $sms_uid,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/campaign-status",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    /*
     * If you want to send SMS to a single/individual recipient (i.e. mobile number),
     * you can use this API.
     * */
    public static function sendSingleSms($mobile_no,$message_body){
        $new_message_body = wordwrap($message_body, 740, "<br />\n");
        $new_message_body = explode("<br />\n",$new_message_body);

        foreach($new_message_body as $message){
            $postdata = array(
                'api_key' => env('SMS_API_KEY'),
                'api_secret' => env('SMS_API_SECRET'),
                'request_type' => 'SINGLE_SMS',
                'message_type' => 'TEXT',
                'mobile' => $mobile_no,
                'message_body' => $message,
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/send-sms",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }

        return $response;
    }

    /*
     * If you want to send OTP SMS to a single/individual recipient (i.e. mobile number),
     * you can use this API.
     * */
    public static function sendOtpSms($mobile_no,$message_body){
        $postdata = array(
            'api_key' => env('SMS_API_KEY'),
            'api_secret' => env('SMS_API_SECRET'),
            'request_type' => 'OTP',
            'message_type' => 'TEXT',
            'mobile' => $mobile_no,
            'message_body' => $message_body,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/send-sms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    /*
     * If you want to send same SMS to multiple recipients (i.e. mobile numbers),
     * you can use this API. Note: You can send maximum 1000 SMS via Bulk SMS API in a single request.
     * Multiple mobile numbers should be comma-separated.
     * */
    public static function sendCampaignSms($mobile_no,$message_body,$campaign_title){
        $new_message_body = wordwrap($message_body, 740, "<br />\n");
        $new_message_body = explode("<br />\n",$new_message_body);

        foreach($new_message_body as $message){
            $postdata = array(
                'api_key' => env('SMS_API_KEY'),
                'api_secret' => env('SMS_API_SECRET'),
                'request_type' => 'GENERAL_CAMPAIGN',
                'message_type' => 'TEXT',
                'mobile' => $mobile_no, // comma separated mobile numbers, ex. 018XXXXXXXX,017XXXXXXXX
                'message_body' => $message_body,
                'campaign_title' => $campaign_title,
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/send-sms",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }

        return $response;
    }

    /*
     * If you want to send different SMS to different recipients (i.e. mobile numbers),
     * you can use this API.
     * You can send maximum 50 SMS via Multibody Campaign API in a single request.
     * */
    public static function sendMultiCampaignSms($mobile_no,$message_body,$campaign_title){
        $postdata = array(
            'api_key' => env('SMS_API_KEY'),
            'api_secret' => env('SMS_API_SECRET'),
            'request_type' => 'MULTIBODY_CAMPAIGN',
            'message_type' => 'TEXT',
            'mobile' => $mobile_no, // comma separated mobile numbers, ex. 018XXXXXXXX,017XXXXXXXX
            'message_body' => $message_body, // Multiple sms body
            'campaign_title' => $campaign_title,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('SMS_PORTAL') . "/api/v1/secure/send-sms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postdata,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}//End
