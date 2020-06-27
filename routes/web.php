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
Route::get('/registration', 'UserController@registration')->name('registration');
Route::get('/thankyou', 'UserController@registrationThankYou');
Route::get('/promotion/{id}', 'UserController@promotion');
Route::post('user/store', 'UserController@store');
Route::get('verify_email', 'UserController@verifyEmail');

Route::get('error_404', 'ErrorController@error404');



Auth::routes();

Route::get('select_user', 'UserController@selectUser');
Route::post('multi_tinent', 'UserController@multiTinent');

Route::post('payment_success/{id}', 'PaymentController@success');

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

Route::get('dashboard', 'UserDashboardController@dashboard');
Route::post('save_buyer', 'UserDashboardController@saveBuyer')->name('buyer.save');

/*User project routs*/
Route::get('select_shipment/{id}', 'UserProjectController@selectShipment')->name('user.select_shipment');
Route::post('store_shipment', 'UserProjectController@storeShipment')->name('user.store_shipment');
Route::get('all_project', 'UserProjectController@allProject')->name('user.all_project');
Route::post('update_project_special_date', 'UserProjectController@updateProjectSpecialDate')->name('user.update_project_special_date');
Route::get('my_project', 'UserProjectController@myProject')->name('user.my_project');
Route::get('my_project_task/{id}', 'UserProjectController@myProjectTask')->name('user.my_project_details');
Route::post('update_task_delivery_status', 'UserProjectController@updateProjectTaskDeliveryStatus')->name('user.update_task_delivery_status');

/*User massage routs*/
Route::get('message', 'MessageController@message');

/*Admin routes*/
Route::get('admin', 'Admin\AdminController@index');

Route::get('admin/users', 'Admin\UserController@userList');
Route::get('admin/user_dashboard', 'Admin\UserController@dashboard');
Route::post('admin/update_user_status', 'Admin\UserController@updateStatus');
Route::post('admin/send_user_email', 'Admin\UserController@sendUserEmail');

Route::post('admin/unlock_project_task', 'Admin\ProjectController@unlockProjectTask');

Route::get('admin/promotion_settings', 'Admin\SettingController@promotionSettings');
Route::post('admin/update_offer', 'Admin\SettingController@updateOffer');
Route::get('admin/project_settings', 'Admin\ProjectController@index');
Route::get('admin/common_settings', 'Admin\SettingController@commonSetting');
Route::post('admin/update_common_settings', 'Admin\SettingController@updateCommonSetting');



