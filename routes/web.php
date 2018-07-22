<?php

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

Route::get('/', 'PreRegistrationController@index')->name('index_page');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user_edit', 'HomeController@user_edit')->name('user_edit');
Route::post('/user_edit', 'HomeController@user_edit_done')->name('user_edit_done');


Route::get('/register_primary', 'PreRegistrationController@primary_registration')->name('pre_register');
Route::get('/verify', 'PreRegistrationController@verify')->name('verify');
Route::post('/register_primary', 'PreRegistrationController@store')->name('pre_register.store');
Route::post('/verify', 'PreRegistrationController@verify_and_proceed')->name('verify.proceed');
Route::post('/register_final', 'PreRegistrationController@final_reg')->name('verify.final');


Route::get('/register_1', 'PreRegistrationController@reg_control')->name('register_1');

Route::post('/password/reset_step_1', 'PreRegistrationController@pass_reset_ver')->name('verify_for_pass');
Route::post('/password/reset_step_2', 'PreRegistrationController@verify_for_pass_change')->name('verify.for.pass.confirm');
Route::post('/password/reset_step_3', 'PreRegistrationController@reset_pass')->name('pass.reset.done');

Route::get('/admin', 'PreRegistrationController@admin_view')->name('admin_view');
Route::post('/admin', 'PreRegistrationController@admin_op_test')->name('admin_test');


Route::get('/profile/{username}','HomeController@profile_show')->name('profile_show');
Route::post('/profile','HomeController@update_avatar')->name('update_avatar');


Route::get('/request_blood','RequestBloodController@show_form')->name('request_blood_show');
Route::post('/request_blood','RequestBloodController@request_blood')->name('request_blood_submt');
Route::get('/request_in_my_area','RequestBloodController@request_in_my_area')->name('request_in_my_area');
Route::get('/change_location','RequestBloodController@change_location')->name('change_location');
Route::post('/change_location','RequestBloodController@change_location_done')->name('change_location_done');

Route::get('/accept_req/{id}','AcceptRequestController@accept_verify')->name('accept_verify');
Route::get('/accept_req/{id}/{id_nt}/{action_id}/{auth_user}','AcceptRequestController@accept_verify_for_notification')->name('accept_verify_for_notification');


Route::get('/suggest/{id}','SuggestPersonController@suggest_form')->name('suggest_form');
Route::post('/suggest/{id}','SuggestPersonController@suggest_confirm')->name('suggest_confirm');
Route::post('/suggest_user/{id}/{id_nt}/{action_id}/{auth_user}','SuggestPersonController@suggest_confirm_for_notification')->name('suggest_confirm_for_notification');
Route::get('/suggest_user/{id}/{id_nt}','SuggestPersonController@suggest_form_for_notification')->name('suggest_form_for_notification');

Route::get('/history','HistoryController@show_history')->name('show_history');

Route::get('/accepted_by/{id}','AcceptRequestController@show_accept_list')->name('show_accept_list');
Route::get('/suggested_by/{id}','SuggestPersonController@show_suggest_list')->name('show_suggest_list');

Route::get('/notification_show/{id}/{action_id}/{auth_user}','NotificationController@notification_show')->name('notification_show');
