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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','PagesController@root')->name('root');

// Auth::routes();
//用户身份证验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login');
Route::post('logout','Auth\LoginController@logout')->name('logout');

//用户注册相关路由
Route::get('register','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register','Auth\RegisterController@register');

//密码重置相关路由
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendLinkEmail')->name('password.email');
Route::get('password/reset/{token}','Auth\ForgotPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ForgotPasswordController@reset')->name('password.update');

//Email 认证相关路由
Route::get('email/vrify','Auth\VerificationController@show')->name('verification.notice');
Route::get('email/vrify/{id}/{hash}','Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend','Auth\VerificationController@resend')->name('verification.resend');


