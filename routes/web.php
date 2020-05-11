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
Route::get('/registration', 'UserController@create');
Route::post('user/store', 'UserController@store');


Auth::routes();

Route::get('/select_user', 'UserController@selectUser');
Route::get('/multi_tinent', 'UserController@multiTinent');

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');
Route::get('profile', 'HomeController@profile')->name('profile');

/*User project routs*/
Route::get('all_project', 'UserProjectController@allProject')->name('user.all_project');
Route::get('my_project', 'UserProjectController@myProject')->name('user.my_project');
