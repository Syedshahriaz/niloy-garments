<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cron/send_task_warning_email', 'CronController@sendTaskWarningEmail')->name('cron.send_task_warning_email');
Route::get('cron/send_subscription_renew_warning_email', 'CronController@sendSubscriptionRenewWarningEmail')->name('cron.send_subscription_renew_warning_email');
Route::get('cron/send_birthday_wish', 'CronController@sendBirthdayWish')->name('cron.send_birthday_wish');

/*
 * Admin auth route
 * */

Route::get('admin/login', 'Admin\AdminController@login');
Route::post('admin/post_login', 'Admin\AdminController@postLogin');
Route::get('admin/logout', 'Admin\AdminController@logout');

/*
 * User auth route
 * */
Route::post('/post_login', 'AuthenticationController@postLogin');
Route::get('logout', 'AuthenticationController@logout');
Route::get('/registration', 'AuthenticationController@registration')->name('registration');
Route::get('/thankyou', 'AuthenticationController@registrationThankYou');
Route::get('/promotion/{id}', 'UserController@promotion');
Route::get('/upgrade_account/{id}', 'UserController@upgradeAccount');
Route::post('/calculate_coupon_code', 'UserController@calculateCouponCode');
Route::get('/select_offer/{id}', 'UserController@selectOffer');
Route::post('/save_offer', 'UserController@saveOffer');
Route::post('user/store', 'AuthenticationController@storeUser');
Route::get('verify_email', 'AuthenticationController@verifyEmail');
Route::get('verify_account', 'AuthenticationController@accountVerificationForm');
Route::post('verify_account', 'AuthenticationController@verifyAccount');
Route::post('resend_registration_otp', 'AuthenticationController@resendRegistrationOtp');
Route::get('expired_account/{id}', 'UserController@expiredAccount');

Route::get('send_sms', 'HomeController@sendSms');

Route::get('error_404', 'ErrorController@error404');


Route::post('email_password_link', 'PublicController@emailPasswordLink');
Route::get('reset_password', 'PublicController@resetPassword');
Route::post('reset_password', 'PublicController@updatePassword');

Route::get('initiate_payment/{id}', 'PaymentController@initiatePayment');
Route::any('payment_success', 'PaymentController@success');
Route::any('payment_fail', 'PaymentController@failed');
Route::any('payment_cancel', 'PaymentController@cancel');
Route::get('test_payment', 'PaymentController@testPayment');

Auth::routes();

Route::get('select_user', 'UserController@selectUser');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');

Route::get('profile', 'UserController@profile')->name('profile');
Route::get('user_list', 'UserController@userList')->name('user.user_list');
Route::get('add_user', 'UserController@addUser')->name('user.add_user');
Route::post('store_new_user', 'UserController@storeNewUser')->name('user.store_new_user');
Route::get('user_details/{id}', 'UserController@userDetails')->name('user.user_details');
Route::get('user_edit/{id}', 'UserController@userEdit')->name('user_edit');
Route::post('user_update', 'UserController@userUpdate')->name('user-update');
Route::get('reset-password', 'UserController@resetPassword')->name('reset-password');
Route::post('update_password', 'UserController@updatePassword')->name('update_password');
Route::post('send_user_otp', 'UserController@sendUserOtp')->name('user.send_user_otp');
Route::post('separate_user', 'UserController@separateUser')->name('user.separate_user');

//Route::get('dashboard', 'UserDashboardController@dashboard');
Route::post('save_buyer', 'UserDashboardController@saveBuyer')->name('buyer.save');
Route::post('update_user_guide_seen_status', 'UserController@updateUserGuideSeenStatus');

/*User project routs*/
Route::get('select_shipment/{id}', 'UserProjectController@selectShipment')->name('user.select_shipment');
Route::post('store_shipment', 'UserProjectController@storeShipment')->name('user.store_shipment');
Route::get('all_project', 'UserProjectController@allProject')->name('user.all_project');
Route::post('update_project_special_date', 'UserProjectController@updateProjectSpecialDate')->name('user.update_project_special_date');
Route::post('update_covid_company', 'UserProjectController@updateCovidCompany')->name('user.update_project_special_date');
Route::get('my_project', 'UserProjectController@myProject')->name('user.my_project');
Route::get('my_project_task/{id}', 'UserProjectController@myProjectTask')->name('user.my_project_details');
Route::post('update_task_delivery_status', 'UserProjectController@updateProjectTaskDeliveryStatus')->name('user.update_task_delivery_status');

/*User massage routs*/
Route::get('message', 'MessageController@message');
Route::post('store_message', 'MessageController@store');
Route::post('get_unread_message', 'MessageController@getUnreadMessage');
Route::post('get_message_details', 'MessageController@getMessageDetails');

Route::get('notifications', 'NotificationController@notifications');
Route::post('get_notifications_ajax', 'NotificationController@getNotificationsAjax');

/*Admin routes*/
Route::get('admin', 'Admin\AdminController@index');

Route::get('admin/users', 'Admin\UserController@userList');
Route::get('admin/deleted_users', 'Admin\UserController@deletedUserList');
Route::get('admin/user_dashboard', 'Admin\UserController@dashboard');
Route::post('admin/update_user_payment', 'Admin\UserController@updatePayment');
Route::post('admin/update_user_status', 'Admin\UserController@updateStatus');
Route::post('admin/delete_user_permanently', 'Admin\UserController@deleteUserPermanently');
Route::post('admin/update_user_offer', 'Admin\UserController@updateUserOffer');
Route::post('admin/update_user_email', 'Admin\UserController@updateUserEmail');
Route::post('admin/send_user_email', 'Admin\UserController@sendUserEmail');
Route::post('admin/send_user_sms', 'Admin\UserController@sendUserSms');

Route::post('admin/unlock_project_task', 'Admin\ProjectController@unlockProjectTask');
Route::post('admin/unlock_shipping_date', 'Admin\ProjectController@unlockShippingDate');
Route::post('admin/unlock_user_gender', 'Admin\UserController@unlockUserGender');

Route::get('admin/promotion_setting', 'Admin\SettingController@promotionSettings');
Route::post('admin/update_offer', 'Admin\SettingController@updateOffer');
Route::get('admin/common_setting', 'Admin\SettingController@commonSetting');
Route::post('admin/update_common_setting', 'Admin\SettingController@updateCommonSetting');
Route::get('admin/offer_price_setting', 'Admin\SettingController@offerPriceSetting');
Route::post('admin/save_country_offer', 'Admin\SettingController@storeCountryOffer');
Route::post('admin/get_country_offer', 'Admin\SettingController@getCountryOffer');
Route::post('admin/update_country_offer', 'Admin\SettingController@updateCountryOffer');
Route::post('admin/update_all_country_offer', 'Admin\SettingController@updateAllCountryOffer');
Route::post('admin/delete_country_offer', 'Admin\SettingController@deleteCountryOffer');
Route::get('admin/project_setting', 'Admin\ProjectController@index');
Route::post('admin/get_project_ajax', 'Admin\ProjectController@getProjectAjax');
Route::post('admin/update_project', 'Admin\ProjectController@updateProject');
Route::post('admin/update_task_rule', 'Admin\ProjectController@updateTaskRule');
Route::post('admin/update_task_title', 'Admin\ProjectController@updateTaskTitle');

Route::get('admin/country_setting', 'Admin\SettingController@countryList');
Route::post('admin/save_country', 'Admin\SettingController@storeCountry');
Route::post('admin/get_country', 'Admin\SettingController@getCountryDetails');
Route::post('admin/update_country', 'Admin\SettingController@updateCountry');
Route::post('admin/delete_country', 'Admin\SettingController@deleteCountry');

Route::get('admin/profession_setting', 'Admin\SettingController@professionList');
Route::post('admin/save_profession', 'Admin\SettingController@storeProfession');
Route::post('admin/get_profession', 'Admin\SettingController@getProfessionDetails');
Route::post('admin/update_profession', 'Admin\SettingController@updateProfession');
Route::post('admin/delete_profession', 'Admin\SettingController@deleteProfession');

Route::get('admin/coupon_setting', 'Admin\SettingController@couponList');
Route::post('admin/save_coupon', 'Admin\SettingController@storeCoupon');
Route::post('admin/get_coupon', 'Admin\SettingController@getCouponDetails');
Route::post('admin/update_coupon', 'Admin\SettingController@updateCoupon');
Route::post('admin/delete_coupon', 'Admin\SettingController@deleteCoupon');

Route::get('admin/subscription_plan_setting', 'Admin\SettingController@subscriptionPlanList');
Route::post('admin/save_subscription_plan', 'Admin\SettingController@storeSubscriptionPlan');
Route::post('admin/get_subscription_plan', 'Admin\SettingController@getSubscriptionPlanDetails');
Route::post('admin/update_subscription_plan', 'Admin\SettingController@updateSubscriptionPlan');
Route::post('admin/delete_subscription_plan', 'Admin\SettingController@deleteSubscriptionPlan');

Route::get('admin/covid_vaccine_companies', 'Admin\SettingController@covidVaccineCompanyList');
Route::post('admin/get_covid_vaccine_company', 'Admin\SettingController@getCovidVaccineCompanyDetails');
Route::post('admin/update_covid_vaccine_company', 'Admin\SettingController@updateCovidVaccineCompany');

Route::post('admin/get_user_covid_vaccine_company', 'Admin\SettingController@getUserCovidVaccineCompanyDetails');
Route::post('admin/update_user_covid_company', 'Admin\SettingController@updateUserCovidVaccineCompany');

Route::get('admin/message', 'Admin\MessageController@message');
Route::post('admin/store_message', 'Admin\MessageController@store');
Route::post('admin/get_unread_message', 'Admin\MessageController@getUnreadMessage');
Route::post('admin/get_message_details', 'Admin\MessageController@getMessageDetails');


Route::get('admin/report', 'Admin\ReportController@allReport');
Route::get('admin/report_gender', 'Admin\ReportController@genderReport');
Route::get('admin/download_report_gender_excel', 'Admin\ReportController@downloadGenderReportExcel');
Route::get('admin/report_age', 'Admin\ReportController@ageReport');
Route::get('admin/download_report_age_excel', 'Admin\ReportController@downloadAgeReportExcel');
Route::get('admin/report_location', 'Admin\ReportController@locationReport');
Route::get('admin/download_report_location_excel', 'Admin\ReportController@downloadLocationReportExcel');
Route::get('admin/report_profession', 'Admin\ReportController@professionReport');
Route::get('admin/download_report_profession_excel', 'Admin\ReportController@downloadProfessionReportExcel');
Route::get('admin/report_offer_purchased', 'Admin\ReportController@offerPurchaseReport');
Route::get('admin/download_report_offer_purchased_excel', 'Admin\ReportController@downloadOfferPurchaseReportExcel');
Route::get('admin/report_sms', 'Admin\ReportController@smsReport');
Route::get('admin/download_report_sms_excel', 'Admin\ReportController@downloadSmsReportExcel');
Route::get('admin/analytics_test', 'Admin\ReportController@analyticsTest');

/*
 * Super admin routes
 * */
Route::get('admin/admin_users', 'SuperAdmin\UserController@userList');
Route::post('admin/edit_admin_user', 'SuperAdmin\UserController@editUser');
Route::post('admin/update_admin_user', 'SuperAdmin\UserController@updateUser');


