<?php

namespace App\Http\Controllers;

use App\Models\OfferPrices;
use App\Models\UserShipment;
use App\SMS;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use Session;
use Spatie\PdfToImage\Pdf;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request){

        $user_id = $request->id;
        $tran_id = "TXN_".uniqid();

        $user = User::where('id',$user_id)->first();
        $offer_price = OfferPrices::where('country_code',$user->country_code)->first();
        if(!empty($offer_price)){
            $currency = $offer_price->currency;
            $offer_amount = $offer_price->offer_price;
        }
        else{
            $currency = 'USD';
            $offer_amount = 10;
        }

        if(COMMON::EASYPAY_MODE=='sandbox'){
            $url = COMMON::EASYPAY_SANDBOX_URL;
            $store_id = Common::EASYPAY_SANDBOX_STORE_ID;
            $signature_key = Common::EASYPAY_SANDBOX_SIGNATURE_KEY;
        }
        else{
            $url = COMMON::EASYPAY_LIVE_URL;
            $store_id = Common::EASYPAY_LIVE_STORE_ID;
            $signature_key = Common::EASYPAY_LIVE_SIGNATURE_KEY;
        }

        if(env('APP_ENV') == 'local'){
            $success_url = 'http://127.0.0.1:8000/payment_success';
            $fail_url = 'http://127.0.0.1:8000/payment_fail';
            $cancel_url = 'http://127.0.0.1:8000/payment_cancel';
        }
        else{
            $success_url = COMMON::PAYMENT_SUCCESS_URL;
            $fail_url = COMMON::PAYMENT_FAILED_URL;
            $cancel_url = COMMON::PAYMENT_CANCEL_URL;
        }

        $fields = array(
            'store_id' => $store_id,
            'amount' => $offer_amount,
            'payment_type' => 'VISA',
            'currency' => $currency,
            'tran_id' => $tran_id,
            'cus_name' => $user->username,
            'cus_email' => $user->email,
            'cus_add1' => '',
            'cus_add2' => '',
            'cus_city' => '',
            'cus_state' => '',
            'cus_postcode' => '',
            'cus_country' => '',
            'cus_phone' => $user->phone,
            'cus_fax' => 'N/A',
            'ship_name' => '',
            'ship_add1' => '',
            'ship_add2' => '',
            'ship_city' => '',
            'ship_state' => '',
            'ship_postcode' => '',
            'ship_country' => '',
            'desc' => 'Offer Payment',
            'success_url' => $success_url,
            'fail_url' => $fail_url,
            'cancel_url' => $cancel_url,
            'opt_a' => $user_id,
            'opt_b' => $request->offer,
            'opt_c' => '',
            'opt_d' => '',
            'signature_key' => $signature_key,
        );

        /*$fields_string = '';
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');*/

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        /*$postdata = http_build_query($fields);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);

        $response = file_get_contents($url, false, $context);*/

        if ($response !='"Invalid Store ID"') {
            $url_forward = str_replace('"', '', stripslashes($response));
            return redirect()->away($url_forward);

        } else {
            echo "API Error #:" . $response;
        }
    }

    public function success(Request $request){
        try {
            $data = $request->all();

            $user_id = $data['opt_a'];
            $pay_status = $data['pay_status'];

            /*
             * Update user payment payment
             * */
            if($pay_status=='Successful'){
                $status = $this->updatePaymentInformation($data);
                if($status=='INVALID_TRANSACTION'){
                    return redirect('promotion/'.$user_id);
                }
            }
            else { // Failed
                return redirect('promotion/'.$user_id);
            }

            /*
             * Re authenticate user
             * */
            $this->reAuthenticateUser($user_id);

            return redirect('select_shipment/'.$user_id);
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'PaymentController', 'success', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function ipnListener(Request $request){
        try{
            /*
             * Validate the requested payment
             * */
            $response = $this->validatePayment($request);

            if($response != 'error')
            {
                /*$status = $this->updatePaymentInformation($response);
                if($status=='VALID' || $status=='VALIDATED'){
                    return 'Successfully updated';
                }*/
            }
            return 'Payment failed';
        }
        catch(\Exception $e){
            //
        }
    }

    private function updatePaymentInformation($response){
        # TO CONVERT AS OBJECT
        $user_id = $response['opt_a'];

        $user = User::where('id',$user_id)->first();
        $user->status = 'active';
        $user->save();

        $payment = Payment::where('user_id', $user_id)->first();
        if(empty($payment)){
            $payment = NEW Payment();
        }
        $payment->user_id = $user_id;
        $payment->amount = $response['other_currency'];
        $payment->store_amount = $response['store_amount'];
        $payment->payment_status = 'Completed';
        $payment->txn_id = $response['epw_txnid'];
        $payment->payment_date = $response['pay_time'];
        $payment->validation_status = 'VALID';
        $payment->response = json_encode($response);
        $payment->updated_at = date('Y-m-d h:i:s');
        $payment->save();

        /*
         * Save offer details
         * */
        $shipment = NEW UserShipment();
        $shipment->user_id = $user_id;
        $offer = $response['opt_b'];
        if($offer == 1){
            $shipment->has_ofer_1 = 1;
            $shipment->has_ofer_2 = 0;
        }
        else{
            $shipment->has_ofer_1 = 0;
            $shipment->has_ofer_2 = 1;
        }

        $shipment->save();

        /*
         * Send registration confirmation message
         * */
        $message_body = 'Your payment has been done successfully. ';
        $message_body .='Please visit www.vujadetec.com to get more information about our product & services.';
        $response = SMS::sendSingleSms($user->phone,$message_body);

        return 'success';
    }

    private function updatePaymentInformationTest($request){
        # TO CONVERT AS OBJECT
        $user_id = $request->id;

        $user = User::where('id',$user_id)->first();
        $user->status = 'active';
        $user->save();

        $payment = Payment::where('user_id', $user_id)->first();
        if(empty($payment)){
            $payment = NEW Payment();
        }
        $payment->user_id = $user_id;
        $payment->amount = 50;
        $payment->store_amount = 48.50;
        $payment->payment_status = 'Completed';
        $payment->txn_id = 'TXN123456_'.$user_id;
        $payment->validation_status = 'VALID';
        $payment->response = '';
        $payment->updated_at = date('Y-m-d h:i:s');
        $payment->save();

        /*
         * Save offer details
         * */
        $shipment = NEW UserShipment();
        $shipment->user_id = $user_id;
        $offer = $request->offer;
        if($offer == 1){
            $shipment->has_ofer_1 = 1;
            $shipment->has_ofer_2 = 0;
        }
        else{
            $shipment->has_ofer_1 = 0;
            $shipment->has_ofer_2 = 1;
        }

        $shipment->save();

        /*
         * Send payment confirmation email
         * */
        $email_to = [$user->email];
        $email_cc = [];
        $email_bcc = [];

        $emailData['from_email'] = Common::FROM_EMAIL;
        $emailData['from_name'] = Common::FROM_NAME;
        $emailData['email'] = $email_to;
        $emailData['email_cc'] = $email_cc;
        $emailData['email_bcc'] = $email_bcc;
        $emailData['user'] = $user;
        $emailData['amount'] = 50;
        $emailData['subject'] = Common::SITE_TITLE.'- Payment confirmation';

        $emailData['bodyMessage'] = '';

        $view = 'emails.payment_confirmation_email';

        $result = SendMails::sendMail($emailData, $view);

        /*
         * Send payment confirmation message
         * */
        $message_body = 'Your payment has been done successfully. ';
        $message_body .='Please visit www.vujadetec.com to get more information about our product & services.';
        $response = SMS::sendSingleSms($user->phone,$message_body);

        return 'success';
    }

    public function failed(Request $request){
        try {
            return 'Payment failed';
            $data = $request->all();
            //echo "<pre>"; print_r($data); echo "</pre>"; exit();
            $user_id = $data['opt_a'];

            /*
             * Re authenticate user
             * */
            $user = $this->reAuthenticateUser($user_id);

            return redirect('promotion/'.$user_id);
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'PaymentController', 'failed', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function cancel(Request $request){
        try {
            return 'Payment cancelled';
            $data = $request->all();
            $user_id = $data['opt_a'];

            /*
             * Re authenticate user
             * */
            $this->reAuthenticateUser($user_id);

            return redirect('promotion/'.$user_id);
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'PaymentController', 'cancel', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    private function reAuthenticateUser($user_id){
        $user = User::find($user_id);
        if($user->parent_id==0){
            Auth::login($user);
        }
        else{
            $user = User::find($user->parent_id);
            Auth::login($user);
        }
        $this->createUserSession($user);
    }

    private function createUserSession($user){
        Session::put('user_id', $user->id);
        Session::put('unique_id', $user->unique_id);
        Session::put('role',$user->role);
        Session::put('username', $user->username);
        Session::put('user_email', $user->email);
        Session::put('first_name', $user->first_name);
        Session::put('last_name', $user->last_name);
        Session::put('user_photo', $user->photo);
        Session::put('user_guide_seen', $user->user_guide_seen);
    }


    public function testPayment(Request $request){

        if(COMMON::EASYPAY_MODE=='sandbox'){
            $url = COMMON::EASYPAY_SANDBOX_URL;
            $store_id = Common::EASYPAY_SANDBOX_STORE_ID;
            $signature_key = Common::EASYPAY_SANDBOX_SIGNATURE_KEY;
        }
        else{
            $url = COMMON::EASYPAY_LIVE_URL;
            $store_id = Common::EASYPAY_LIVE_STORE_ID;
            $signature_key = Common::EASYPAY_LIVE_SIGNATURE_KEY;
        }
        if(env('APP_ENV') == 'local'){
            $success_url = 'http://127.0.0.1:8000/payment_success';
            $fail_url = 'http://127.0.0.1:8000/payment_fail';
            $cancel_url = 'http://127.0.0.1:8000/payment_cancel';
        }
        else{
            $success_url = COMMON::PAYMENT_SUCCESS_URL;
            $fail_url = COMMON::PAYMENT_FAILED_URL;
            $cancel_url = COMMON::PAYMENT_CANCEL_URL;
        }

        $fields = array(
            'store_id' => $store_id,
            'amount' => 2,
            'payment_type' => 'VISA',
            'currency' => 'BDT',
            'tran_id' => "TXN_".uniqid(),
            'cus_name' => 'Muhin',
            'cus_email' => 'muhin.diu092@gmail.com',
            'cus_add1' => '',
            'cus_add2' => '',
            'cus_city' => '',
            'cus_state' => '',
            'cus_postcode' => '',
            'cus_country' => '',
            'cus_phone' => '01749472736',
            'cus_fax' => 'N/A',
            'ship_name' => '',
            'ship_add1' => '',
            'ship_add2' => '',
            'ship_city' => '',
            'ship_state' => '',
            'ship_postcode' => '',
            'ship_country' => '',
            'desc' => 'Offer Payment',
            'success_url' => $success_url,
            'fail_url' => $fail_url,
            'cancel_url' => $cancel_url,
            'opt_a' => 4,
            'opt_b' => 1,
            'opt_c' => '',
            'opt_d' => '',
            'signature_key' => $signature_key,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://securepay.easypayway.com/payment/request.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        //return $response;
        if ($response !='"Invalid Store ID"') {
            $url_forward = str_replace('"', '', stripslashes($response));
            echo "<meta http-equiv='refresh' content='0;url=".$url_forward."'>";
            # header("Location: ". $url_forward);
            exit;

        } else {
            echo "API Error #:" . $response;
        }
    }
}
