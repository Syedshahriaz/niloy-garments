<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\OfferPrices;
use App\Models\Country;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function commonSetting(Request $request){
        try{
            $settings = Setting::first();
            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.common',compact('settings'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.common',compact('settings'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'commonSetting', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateCommonSetting(Request $request){
        try{
            $user = Auth::user();
            $setting = Setting::first();
            $setting->message_to_user = $request->message_to_user;
            if($request->weekly_target==''){
                $weekly_target = 0;
            }
            else{
                $weekly_target = $request->weekly_target;
            }
            $setting->weekly_target = $weekly_target;
            $setting->updated_at = date('Y-m-d h:i:s');
            $setting->save();
            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateCommonSetting', $e->getLine(),
                //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function promotionSettings(Request $request){
        try{
            $offer = Offer::first();
            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.common',compact('offer'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.promotion',compact('offer'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'promotionSettings', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateOffer(Request $request){
        try{
            $names = $request->name;
            $details = $request->details;

            $offer = Offer::first();
            $offer->offer1_name = $request->offer1_name;
            $offer->offer1_details = $request->offer1_details;
            $offer->offer2_name = $request->offer2_name;
            $offer->offer2_details = $request->offer2_details;
            $offer->offer3_name = $request->offer3_name;
            $offer->offer3_details = $request->offer3_details;
            $offer->updated_at = date('Y-m-d h:i:s');
            $offer->save();

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function offerPriceSetting(Request $request){
        try{
            $countries = Country::where('status','active')->get();
            $offer_prices = OfferPrices::orderBy('country_name','ASC')
                ->get();
            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.offer_prices',compact('countries','offer_prices'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.offer_prices',compact('countries','offer_prices'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'offerPriceSetting', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function storeCountryOffer(Request $request){
        try{
            $countryData = explode('#',$request->country);
            $oldCountry = OfferPrices::where('country_code',$countryData[1])->first();
            if(!empty($oldCountry)){
                return ['status'=>401, 'reason'=>'This country already added'];
            }

            $offer_prices = NEW OfferPrices();
            $offer_prices->country_name = $countryData[0];
            $offer_prices->country_code = $countryData[1];
            $offer_prices->currency = $request->currency;
            $offer_prices->offer_price = $request->offer_price;
            $offer_prices->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'storeCountryOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getCountryOffer(Request $request){
        try{
            $offer_price = OfferPrices::where('id',$request->id)->first();

            return ['status'=>200, 'offer_price'=>$offer_price];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getCountryOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateCountryOffer(Request $request){
        try{
            $offer_prices = OfferPrices::where('id',$request->country_id)->first();
            $offer_prices->currency = $request->currency;
            $offer_prices->offer_price = $request->offer_price;
            $offer_prices->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateCountryOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
