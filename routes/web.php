<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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
//     return view('home');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/district-chart/fetch', 'HomeController@fetch');
Route::post('/symptoms-chart/fetch', 'HomeController@fetchSymptoms');
Route::get('/report/create', 'ReportController@create')->name('report');
Route::post('/report', 'ReportController@store',['as'=>'report']);
Route::post('/district/fetch', 'ReportController@fetch');
Route::get('/symptoms', 'HomeController@symptoms')->name('symptoms');
Route::get('/hospitals', 'HomeController@hospitals')->name('hospitals');
// Route::patch('/admin/report/{id}', 'ReportController@update');

// Route::get('/admin/mail', function(){
//     $data = [
//         'title' => 'Submission of report on HFMD reporting system',
//         'content' => 'Your report has been submitted and waiting review by an admin.',
//     ];

//     Mail::send('emails.test', $data, function($message){
//         $message->to('chunshui7347@gmail.com', 'chunshui')->subject('Reporting on HFMD reporting system');
//     });
// });

Route::group(['middleware'=>'admin'], function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::resource('admin/report', 'AdminReportsController',['as'=>'admin']);
    Route::get('/changeFatal', 'AdminReportsController@changeFatal');
    Route::get('/changeVerify', 'AdminReportsController@changeVerify');
    Route::post('/admin/reports/deleteData', 'AdminReportsController@deleteData');
    Route::post('/admin/reports/getTableData', 'AdminReportsController@getTableData');
    Route::get('/admin/reports/show/{id}', 'AdminReportsController@show');

    Route::resource('admin/manageUsers', 'AdminManageUsersController', ['as'=>'admin']);
    Route::get('/changeRole', 'AdminManageUsersController@changeRole');
    Route::post('/admin/manageUsers/getTableData', 'AdminManageUsersController@getTableData');

    Route::resource('admin/symptoms', 'AdminSymptomsController', ['as' => 'admin']);
    Route::post('/admin/symptoms/getTableData','AdminSymptomsController@getTableData');
    Route::post('/admin/symptoms/editData', 'AdminSymptomsController@editData');
    Route::post('/admin/symptoms/deleteData', 'AdminSymptomsController@deleteData');

    Route::resource('/admin/notifications', 'AdminNotificationsController', ['as' => 'admin']);
    Route::post('/admin/notifications/getTableData', 'AdminNotificationsController@getTableData');
    Route::post('/admin/notifications/editData', 'AdminNotificationsController@editData');
    Route::post('/admin/notifications/deleteData', 'AdminNotificationsController@deleteData');
});

