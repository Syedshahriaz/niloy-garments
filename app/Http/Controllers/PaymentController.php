<?php

namespace App\Http\Controllers;

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
        //try {
            $user_id = $request->id;
            $payment = Payment::where('user_id', $user_id)->first();
            if(empty($payment)){
                $payment = NEW Payment();
            }
            $payment->user_id = $user_id;
            $payment->amount = 50;
            $payment->payment_status = 'Completed';
            $payment->txn_id = 'Txn123456';
            $payment->save();

            return redirect('select_shipment/'.$user_id);
        /*} catch (\Exception $e) {
            SendMails::sendErrorMail($e->getMessage(), null, 'PaymentController', 'success', $e->getLine(),
                $e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }*/
    }
}
