<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\OfferPrices;
use App\Models\Country;
use App\Models\Profession;
use App\Common;
use App\SendMails;
use Illuminate\Support\Facades\Auth;
use DB;

class SettingController extends Controller
{
    public function commonSetting(Request $request){
        try{
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
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
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
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
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            $countries = Country::where('status','active')->get();
            $offer_prices = OfferPrices::select('offer_prices.*','countries.name as country_name','countries.dial_code')
                ->join('countries','countries.id','=','offer_prices.country_id')
                ->orderBy('country_name','ASC')
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
            return back();
        }
    }

    public function storeCountryOffer(Request $request){
        try{
            $oldCountry = OfferPrices::where('country_id',$request->country_id)->first();
            if(!empty($oldCountry)){
                return ['status'=>401, 'reason'=>'This country already added'];
            }

            $offer_prices = NEW OfferPrices();
            $offer_prices->country_id = $request->country;
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

    public function updateAllCountryOffer(Request $request){
        try{
            DB::table('offer_prices')
                ->update(array(
                    'currency' => $request->currency,
                    'offer_price' => $request->offer_price
                    )
                );

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateAllCountryOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deleteCountryOffer(Request $request){
        try{
            OfferPrices::where('id',$request->country_id)->delete();
            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'deleteCountryOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function countryList(Request $request){
        try{
            $countries = Country::orderBy('name','ASC')->get();

            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.country',compact('countries'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.country',compact('countries'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'storeCountry', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function storeCountry(Request $request){
        try{
            $country = NEW Country();
            $country->name = $request->name;
            $country->country_code = $request->country_code;
            $country->dial_code = $request->dial_code;
            $country->save();

            /*
             * Save country offer price
             * */
            $offer_prices = NEW OfferPrices();
            $offer_prices->country_id = $country->id;
            $offer_prices->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'storeCountry', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getCountryDetails(Request $request){
        try{
            $country = Country::where('id',$request->id)->first();

            return ['status'=>200, 'reason'=>'', 'country'=>$country];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getCountryDetails', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateCountry(Request $request){
        try{
            $country = Country::where('id',$request->country_id)->first();
            $country->name = $request->name;
            $country->country_code = $request->country_code;
            $country->dial_code = $request->dial_code;
            $country->save();

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateCountry', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deleteCountry(Request $request){
        try{
            Country::where('id',$request->id)->delete();

            // Deleting country offer
            OfferPrices::where('country_id',$request->id)->delete();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'deleteCountry', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function professionList(Request $request){
        try{
            $professions = Profession::get();

            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.profession',compact('professions'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.profession',compact('professions'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'professionList', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function storeProfession(Request $request){
        try{
            $profession = NEW Profession();
            $profession->title = $request->title;
            $profession->description = $request->description;
            $profession->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'storeProfession', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getProfessionDetails(Request $request){
        try{
            $profession = Profession::where('id',$request->id)->first();

            return ['status'=>200, 'reason'=>'', 'profession'=>$profession];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getProfessionDetails', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateProfession(Request $request){
        try{
            $profession = Profession::where('id',$request->profession_id)->first();
            $profession->title = $request->title;
            $profession->description = $request->description;
            $profession->save();

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateProfession', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deleteProfession(Request $request){
        try{
            Profession::where('id',$request->id)->delete();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'deleteProfession', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
