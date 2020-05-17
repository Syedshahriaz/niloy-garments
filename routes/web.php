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

Route::post('/post_login', 'AuthenticationController@postLogin');
Route::get('/registration', 'UserController@registration')->name('registration');
Route::get('/promotion', 'UserController@promotion');
Route::post('user/store', 'UserController@store');


Auth::routes();

Route::get('select_user', 'UserController@selectUser');
Route::post('multi_tinent', 'UserController@multiTinent');

Route::post('payment_success', 'PaymentController@success');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');

Route::get('profile', 'UserController@profile')->name('profile');
Route::get('profile-edit', 'UserController@profileEdit')->name('profile_edit');
Route::post('profile_update', 'UserController@profileUpdate')->name('profile-update');
Route::get('reset-password', 'UserController@resetPassword')->name('reset-password');
Route::post('update_password', 'UserController@updatePassword')->name('update_password');
Route::get('add_user', 'UserController@addUser')->name('user.add_user');
Route::post('store_new_user', 'UserController@storeNewUser')->name('user.store_new_user');

/*User project routs*/
Route::get('select_shipment', 'UserProjectController@selectShipment')->name('user.select_shipment');
Route::post('store_shipment', 'UserProjectController@storeShipment')->name('user.store_shipment');
Route::get('all_project', 'UserProjectController@allProject')->name('user.all_project');
Route::post('add_project', 'UserProjectController@addProject')->name('user.add_project');
Route::get('my_project', 'UserProjectController@myProject')->name('user.my_project');


