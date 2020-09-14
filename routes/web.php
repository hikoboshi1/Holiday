<?php

use App\Http\Controllers\HolidayAppController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HolidaySaveMiddleware;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//一覧へ
Route::get('dcfportal/holiday_applications', 'HolidayAppController@index')->name('holiday_index');

//申請画面へ //第一引数が、127.0.0.1の後に続くURL。第二引数のクラス@メソッドの中の処理を実行
Route::get('dcfportal/holiday_applications/new', 'HolidayAppController@create')->name('holiday_create');

//新規作成:DB登録
Route::post('dcfportal/holiday_applications/new', 'HolidayAppController@store')->name('holiday_store');

//合計期間の算出を行うAjax通信
Route::get('dcfportal/get_holiday_duration', 'HolidayAppController@get_holiday_duration')->name('get_holiday_duration');

//詳細へ
Route::get('dcfportal/holiday_applications/{holidayApplication}/show', 'HolidayAppController@detail')->name('holiday_show');

//修正画面
Route::get('dcfportal/holiday_applications/{holidayApplication}/edit', 'HolidayAppController@edit')->name('holiday_edit');

//更新
Route::post('dcfportal/holiday_applications/{holidayApplication}/edit', 'HolidayAppController@update')->name('holiday_update');


    //HOME
    Route::get('admin/home', 'HomeController@admin_home')->name('admin_home');
    //一覧
    Route::get('dcfportal/admin/holiday_applications', 'HolidayAppController@admin_holiday_index')->name('admin_holiday_index');
    //詳細
    Route::get('dcfportal/admin/holiday_applications/{holidayApplication}/show', 'HolidayAppController@admin_holiday_show')->name('admin_holiday_show');
    //確定
    Route::put('dcfportal/admin/holiday_applications/{holidayApplication}/show', 'HolidayAppController@admin_holiday_confilm')->name('admin_holiday_confilm');
    //確定取消
    Route::put('dcfportal/admin/holiday_applications/{holidayApplication}/show', 'HolidayAppControkker@admin_holiday_reject')->name('admmin_holiday_reject');
