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
//     return view('home');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/report/create', 'ReportController@create')->name('report');
Route::post('/report', 'ReportController@store',['as'=>'report']);
// Route::patch('/admin/report/{id}', 'ReportController@update');



Route::group(['middleware'=>'admin'], function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::resource('admin/report', 'AdminReportsController',['as'=>'admin']);
    Route::get('/changeFatal', 'AdminReportsController@changeFatal');
});
