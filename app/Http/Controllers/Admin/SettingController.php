<?php

namespace App\Http\Controllers\Admin;

use App\Models\CovidVaccineDose;
use App\Models\UserProject;
use App\Models\UserShipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\OfferPrices;
use App\Models\OfferPriceDetail;
use App\Models\Country;
use App\Models\Profession;
use App\Models\Coupon;
use App\Models\SubscriptionPlan;
use App\Models\CovidVaccineCompany;
use App\Models\UserCovidVaccineCompany;
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
            if(!Common::can_access('common_setting')){
                return redirect('error_404');
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
            if(!Common::can_access('promotion_setting')){
                return redirect('error_404');
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
            if(!Common::can_access('offer_price_setting')){
                return redirect('error_404');
            }

            $countries = Country::where('status','active')->get();
            $currencies = Country::select('currency')
                ->where('status','active')
                ->groupBY('currency')
                ->orderBY('currency','ASC')
                ->get();
            $subscription_plans = SubscriptionPlan::where('status','active')->get();
            $offer_prices = OfferPrices::select('offer_prices.*','countries.name as country_name','countries.dial_code')
                ->join('countries','countries.id','=','offer_prices.country_id')
                ->orderBy('country_name','ASC')
                ->get();
            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.offer_prices',compact('countries','currencies','offer_prices','subscription_plans'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.offer_prices',compact('countries','currencies','offer_prices','subscription_plans'));
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
            $offer_price = OfferPrices::with('offer_details')
                ->where('id',$request->id)
                ->first();

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
            DB::beginTransaction();

            $subscrintion_plans = $request->subscription_plan_id;
            $offer_price_details = $request->offer_price;

            $offer_prices = OfferPrices::where('id',$request->country_id)->first();
            $offer_prices->currency = $request->currency;
            $offer_prices->save();

            foreach($offer_price_details as $key=>$price){
                $opd = OfferPriceDetail::where('offer_price_id',$offer_prices->id)
                    ->where('subscription_plan_id',$subscrintion_plans[$key])
                    ->first();
                if(empty($opd)){
                    $opd = NEW OfferPriceDetail();
                    $opd->offer_price_id = $offer_prices->id;
                    $opd->subscription_plan_id = $subscrintion_plans[$key];
                }
                if($opd->offer_price==''){
                    $opd->offer_price = 10;
                }
                else{
                    $opd->offer_price = $offer_price_details[$key];
                }
                $opd->save();
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateCountryOffer', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateAllCountryOffer(Request $request){
        try{
            DB::beginTransaction();

            $subscrintion_plans = $request->subscription_plan_id;
            $offer_price_details = $request->offer_price;

            /*
             * First remove all previous offer details
             * */
            OfferPriceDetail::truncate();

            /*
             * Now add new offer price detail
             * */
            $offer_prices = OfferPrices::select('offer_prices.*')
                ->get();

            foreach($offer_prices as $offer_price){
                $offer_price->currency = $request->currency;
                $offer_price->save();

                foreach($offer_price_details as $key=>$price){
                    $opd = NEW OfferPriceDetail();
                    $opd->offer_price_id = $offer_price->id;
                    $opd->subscription_plan_id = $subscrintion_plans[$key];
                    $opd->offer_price = $offer_price_details[$key];
                    $opd->save();
                }
            }

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
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
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            if(!Common::can_access('country_setting')){
                return redirect('error_404');
            }

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
            $country->currency = $request->currency;
            $country->save();

            /*
             * Save country offer price
             * */
            $offer_prices = NEW OfferPrices();
            $offer_prices->country_id = $country->id;
            $offer_prices->currency = $request->currency;
            $offer_prices->save();

            /*
             * Save offer details
             * */
            $subscription_plans = SubscriptionPlan::where('status','active')->get();

            foreach($subscription_plans as $key=>$plan){
                $opd = NEW OfferPriceDetail();
                $opd->offer_price_id = $offer_prices->id;
                $opd->subscription_plan_id = $plan->id;
                $opd->save();
            }

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
            $country->currency = $request->currency;
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
            $offer_price = OfferPrices::where('country_id',$request->id)->first();

            OfferPrices::where('country_id',$request->id)->delete();

            // Deleting country offer detail

            OfferPriceDetail::where('offer_price_id',$offer_price->id)->delete();

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
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            if(!Common::can_access('profession_setting')){
                return redirect('error_404');
            }

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

    public function couponList(Request $request){
        try{
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            if(!Common::can_access('coupon_setting')){
                return redirect('error_404');
            }

            $coupons = Coupon::get();

            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.coupon',compact('coupons'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.coupon',compact('coupons'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'couponList', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function storeCoupon(Request $request){
        try{
            $coupon = NEW Coupon();
            $coupon->code = $request->code;
            $coupon->discount = $request->discount;
            $coupon->availability = $request->availability;
            $coupon->save();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'storecoupon', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getCouponDetails(Request $request){
        try{
            $coupon = Coupon::where('id',$request->id)->first();

            return ['status'=>200, 'reason'=>'', 'coupon'=>$coupon];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getcouponDetails', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateCoupon(Request $request){
        try{
            $coupon = Coupon::where('id',$request->coupon_id)->first();
            $coupon->code = $request->code;
            $coupon->discount = $request->discount;
            $coupon->availability = $request->availability;
            $coupon->save();

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updatecoupon', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deleteCoupon(Request $request){
        try{
            Coupon::where('id',$request->id)->delete();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'deletecoupon', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function subscriptionPlanList(Request $request){
        try{
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }
            if(!Common::can_access('subscription_plan_setting')){
                return redirect('error_404');
            }

            $subscription_plans = SubscriptionPlan::get();

            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.subscription_plan',compact('subscription_plans'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.subscription_plan',compact('subscription_plans'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'couponList', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function storeSubscriptionPlan(Request $request){
        try{
            $subscription_plan = NEW SubscriptionPlan();
            if($request->is_lifetime == ''){
                $isDuplicateYear = SubscriptionPlan::where('year',$request->year)->first();
                if(!empty($isDuplicateYear)){
                    return [ 'status' => 401, 'reason' => 'This plan already added'];
                }

                $subscription_plan->name = 'Upto '.$request->year.' years';
                $subscription_plan->year = $request->year;
            }
            else{
                $isDuplicateYear = SubscriptionPlan::where('name','Lifetime')->first();
                if(!empty($isDuplicateYear)){
                    return [ 'status' => 401, 'reason' => 'This plan already added'];
                }

                $subscription_plan->name = 'Lifetime';
                $subscription_plan->year = '';
                $subscription_plan->is_lifetime = 1;
            }
            $subscription_plan->save();

            /*
             * Save offer price details for new subscription
             * */
            $offer_prices = OfferPrices::get();

            foreach($offer_prices as $key=>$offer_price){
                $opd = NEW OfferPriceDetail();
                $opd->offer_price_id = $offer_price->id;
                $opd->subscription_plan_id = $subscription_plan->id;
                $opd->save();
            }

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'storesubscription_plan', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getSubscriptionPlanDetails(Request $request){
        try{
            $subscription_plan = SubscriptionPlan::where('id',$request->id)->first();

            return ['status'=>200, 'reason'=>'', 'subscription_plan'=>$subscription_plan];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getsubscription_planDetails', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateSubscriptionPlan(Request $request){
        try{
            $subscription_plan = SubscriptionPlan::where('id',$request->subscription_plan_id)->first();
            if($request->is_lifetime == ''){
                $isDuplicateYear = SubscriptionPlan::where('year',$request->year)->first();
                if(!empty($isDuplicateYear) && $isDuplicateYear->id != $request->subscription_plan_id){
                    return [ 'status' => 401, 'reason' => 'This plan already added'];
                }

                $subscription_plan->name = 'Upto '.$request->year.' years';
                $subscription_plan->year = $request->year;
            }
            else{
                $isDuplicateYear = SubscriptionPlan::where('name','Lifetime')->first();
                if(!empty($isDuplicateYear) && $isDuplicateYear->id != $request->subscription_plan_id){
                    return [ 'status' => 401, 'reason' => 'This plan already added'];
                }

                $subscription_plan->name = 'Lifetime';
                $subscription_plan->year = '';
            }
            $subscription_plan->save();

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updatesubscription_plan', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function deleteSubscriptionPlan(Request $request){
        try{
            SubscriptionPlan::where('id',$request->id)->delete();

            /*
             * Delete offer price details for this subscription
             * */
            $opd = OfferPriceDetail::where('subscription_plan_id',$request->id)->delete();

            return ['status'=>200, 'reason'=>'Successfully deleted'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'deletesubscription_plan', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function covidVaccineCompanyList(Request $request){
        try{
            if (!Common::is_admin_login()) {
                return redirect('admin/login');
            }

            $covid_vaccine_companies = CovidVaccineCompany::get();

            if($request->ajax()) {
                $returnHTML = View::make('admin.settings.covid_vaccine_company',compact('covid_vaccine_companies'))->renderSections()['content'];
                return response()->json(array('status' => 200, 'html' => $returnHTML));
            }
            return view('admin.settings.covid_vaccine_company',compact('covid_vaccine_companies'));
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'covidVaccineCompanyList', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getCovidVaccineCompanyDetails(Request $request){
        try{
            $covid_vaccine_company = CovidVaccineCompany::where('id',$request->id)->first();

            return ['status'=>200, 'reason'=>'', 'covid_vaccine_company'=>$covid_vaccine_company];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getCovidVaccineCompanyDetails', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function getUserCovidVaccineCompanyDetails(Request $request){
        try{
            $user_covid_vaccine_company = UserCovidVaccineCompany::where('user_id',$request->user_id)->first();

            /*
             * Getting user free project id
             * */
            $user_project = UserProject::select('user_projects.id as user_project_id')
                ->join('projects','projects.id','=','user_projects.project_id')
                ->where('user_projects.user_id',$request->user_id)
                ->where('projects.type','free')
                ->first();

            return ['status'=>200, 'reason'=>'', 'user_covid_vaccine_company'=>$user_covid_vaccine_company, 'user_project'=>$user_project];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'getUserCovidVaccineCompanyDetails', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateUserCovidVaccineCompany(Request $request){
        try{
            $user_id = $request->user_id;

            $user_vaccine_company = UserCovidVaccineCompany::where('user_id',$user_id)->first();
            if(empty($user_vaccine_company)){
                $user_vaccine_company = NEW UserCovidVaccineCompany();
            }

            $user_vaccine_company->user_id = $user_id;
            $user_vaccine_company->company_id = $request->covid_vaccine_company;
            $user_vaccine_company->user_project_id = $request->user_project_id;
            $user_vaccine_company->dose_date = date('Y-m-d');
            $user_vaccine_company->save();

            DB::beginTransaction();
            /*
             * First remove user project tasks for this user project if any
             * */
            $result = Common::removeUserProjectTask($request->user_project_id);

            /*
             * Now adding new tasks for this user projects
             * */
            $user_project = UserProject::where('id',$request->user_project_id)
                ->first();
            $shipment = UserShipment::where('user_id',$request->user_id)->first();
            $covid_doses = CovidVaccineDose::where('company_id',$request->covid_vaccine_company)->get();

            $result = Common::saveUserCovidProjectTask($covid_doses,$user_project,$shipment,$user_vaccine_company);

            DB::commit();

            return ['status'=>200, 'reason'=>'Successfully saved'];
        }
        catch (\Exception $e) {
            DB::rollback();
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateUserCovidVaccineCompany', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }

    public function updateCovidVaccineCompany(Request $request){
        try{
            $covid_vaccine_company = CovidVaccineCompany::where('id',$request->covid_vaccine_company_id)->first();
            $covid_vaccine_company->name = $request->name;
            $covid_vaccine_company->save();

            return ['status'=>200, 'reason'=>'Successfully updated'];
        }
        catch (\Exception $e) {
            //SendMails::sendErrorMail($e->getMessage(), null, 'Admin/SettingController', 'updateCovidVaccineCompany', $e->getLine(),
            //$e->getFile(), '', '', '', '');
            // message, view file, controller, method name, Line number, file,  object, type, argument, email.
            return [ 'status' => 401, 'reason' => 'Something went wrong. Try again later'];
        }
    }
}
