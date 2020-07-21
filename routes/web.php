<?php

use App\Http\Controllers\HolidayApplicationController;
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

Route::get('/new', 'HolidayAppController@create');//127.0.0.1:8000の後ろに、「/new」をつけるとHolidayAppControllerで示した先のページへ飛ぶ。という意味
//Routeはルーティング、行先を示している

Route::post('/new', 'HolidayAppController@store')->name('store');//DBに登録

Route::get('/index', 'HolidayHomeController@index');//一覧画面移動

Route::get('/detail/{id}', 'HolidayDetailController@detail')->name('show');//詳細画面移動