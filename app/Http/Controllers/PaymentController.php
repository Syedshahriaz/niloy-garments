<?php

namespace App\Http\Controllers;

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
        // Test update as payment getway not ready yet
        $user_id = $request->id;
        $result = $this->updatePaymentInformationTest($request);
        return redirect('select_shipment/'.$user_id);
        // End of test update

        $user_id = $request->id;
        $tran_id = "TRN_".uniqid();

        $user = User::where('id',$user_id)->first();

        if(COMMON::SECUREPAY_MODE=='sandbox'){
            $url = COMMON::SECUREPAY_SANDBOX_URL;
            $store_id = Common::SECUREPAY_SANDBOX_STORE_ID;
        }
        else{
            $url = COMMON::SECUREPAY_LIVE_URL;
            $store_id = Common::SECUREPAY_LIVE_STORE_ID;
        }
        $fields = array(
            'store_id' => $store_id,
            'amount' => 50,
            'payment_type' => 'VISA',
            'currency' => 'BDT',
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
            'success_url' => COMMON::PAYMENT_SUCCESS_URL,
            'fail_url' => COMMON::PAYMENT_FAILED_URL,
            'cancel_url' => COMMON::PAYMENT_CANCEL_URL,
            'opt_a' => $user_id,
            'opt_b' => $request->offer,
            'opt_c' => '',
            'opt_d' => '',
            'signature_key' => COMMON::SECUREPAY_SIGNATURE_KEY);

        $fields_string = '';
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);

        //return $response;
        if ($response !='"Invalid Store ID"') {
            $url_forward = str_replace('"', '', stripslashes($response));
            curl_close($ch);
            echo $url_forward; exit();

            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            # echo "<meta http-equiv='refresh' content='0;url=".$url_forward."'>";
            header("Location: ". $url_forward);
            exit;

        } else {
            echo "API Error #:" . $response;
            //echo "<br> My request url: ".$url;
            //echo "<br> My request parameters";
            //echo "<pre>"; print_r($fields); echo "</pre>";
        }
    }

    public function success(Request $request){
        try {

            $user_id = $request->value_a;
            $pay_status = $request->pay_status;

            /*
             * Update user payment payment
             * */
            if($pay_status=='Successful'){
                $status = $this->updatePaymentInformation($request);
                if($status=='INVALID_TRANSACTION'){
                    return redirect('promotion/'.$user_id);
                }
            }
            else { // Failed
                return redirect('promotion/'.$user_id);
            }

            /*$user = User::find($user_id);
            if($user->parent_id==0){
                Auth::login($user);
            }
            else{
                $user = User::find($user->parent_id);
                Auth::login($user);
            }
            $this->createUserSession($user);*/

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

    private function validatePayment($request){
        $val_id=urlencode($request->val_id);
        $store_id=urlencode(env('SSL_COMMERZE_STORE_ID'));
        $store_passwd=urlencode(env('SSL_COMMERZE_STORE_PASSWORD'));
        $requested_url = (env('SSL_COMMERZE_PORTAL')."/validator/api/validationserverAPI.php?val_id=".$val_id."&store_id=".$store_id."&store_passwd=".$store_passwd."&v=1&format=json");

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $requested_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false); # IF YOU RUN FROM LOCAL PC
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false); # IF YOU RUN FROM LOCAL PC

        $response = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($code == 200 && !( curl_errno($handle)))
        {
            return $response;
        }
        else{
            return 'error';
        }
    }

    private function updatePaymentInformation($response){
        # TO CONVERT AS OBJECT
        $result = json_decode($response);
        $user_id = $result->value_a;

        $user = User::where('id',$user_id)->first();
        $user->status = 'active';
        $user->save();

        $payment = Payment::where('user_id', $user_id)->first();
        if(empty($payment)){
            $payment = NEW Payment();
        }
        $payment->user_id = $user_id;
        $payment->amount = $result->amount;
        $payment->store_amount = $result->store_amount;
        $payment->payment_status = 'Completed';
        $payment->txn_id = $result->epw_txnid;
        $payment->validation_status = 'VALID';
        $payment->response = $response;
        $payment->updated_at = date('Y-m-d h:i:s');
        $payment->save();

        /*
         * Save offer details
         * */
        $shipment = NEW UserShipment();
        $shipment->user_id = $user_id;
        $offer = $result->value_b;
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
         * Send registration confirmation message
         * */
        $message_body = 'Your payment has been done successfully. ';
        $message_body .='Please visit www.vujadetec.com to get more information about our product & services.';
        $response = SMS::sendSingleSms($user->phone,$message_body);

        return 'success';
    }

    public function failed(Request $request){
        try {
            $user_id = $request->value_a;

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
            $user_id = $request->value_a;

            return redirect('promotion/'.$user_id);
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'PaymentController', 'cancel', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
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
}
