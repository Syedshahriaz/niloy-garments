<?php

namespace App\Http\Controllers;

use App\Common;
use Illuminate\Http\Request;
use App\Models\User;
use App\SMS;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(Common::is_user_login()){
            return redirect('all_project');
        }
        if(Common::is_admin_login()){
            return redirect('admin');
        }

        return redirect('error_404');
    }

    public function sendSms(Request $request)
    {
        try {
            $postdata = array(
                'api_key' => env('SMS_API_KEY'),
                'api_secret' => env('SMS_API_SECRET'),
                'request_type' => 'SINGLE_SMS',
                'message_type' => 'TEXT',
                'mobile' => '01749472736',
                'message_body' => 'This is a test SMS from Niloy Garments. Please ignore this.',
            );

            //$result = file_get_contents(env('SMS_PORTAL') . '/api/v1/secure/send-sms', false, $context);

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
            echo "<pre>"; print_r($response); echo "</pre>";
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
}
