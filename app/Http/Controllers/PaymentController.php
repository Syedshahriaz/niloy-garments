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
    public function success(Request $request){
        try {
            $user_id = $request->id;
            $user = User::where('id',$user_id)->first();

            $payment = Payment::where('user_id', $user_id)->first();
            if(empty($payment)){
                $payment = NEW Payment();
            }
            $payment->user_id = $user_id;
            $payment->amount = 50;
            $payment->payment_status = 'Completed';
            $payment->txn_id = 'Txn123456';
            $payment->save();

            /*
             * Save offer details
             * */
            $shipment = NEW UserShipment();
            $shipment->user_id = $user_id;
            if($request->offer == 1){
                $shipment->has_ofer_1 = 1;
                $shipment->has_ofer_2 = 0;
            }
            else{
                $shipment->has_ofer_1 = 0;
                $shipment->has_ofer_2 = 1;
            }
            /*if($request->gender == 'Female'){
                $shipment->has_ofer_3 = 1;
            }*/

            $shipment->save();

            /*
             * Send registration confirmation message
             * */
            $message_body = 'Your payment has been done successfully. ';
            $message_body .='Please visit www.vujadetec.com to get more information about our product & services.';
            $response = SMS::sendSingleSms($user->phone,$message_body);

            return redirect('select_shipment/'.$user_id);
        } catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'PaymentController', 'success', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
