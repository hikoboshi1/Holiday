<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayApplication;
use Illuminate\Support\Facades\Auth;

class HolidayHomeController extends Controller
{
    //
   public function index(){
       
       //ログインしているユーザーと一致しているレコードを取得
       $items = HolidayApplication::where('user_id', '=', Auth::user()->id)->get();
       return view('holidayHome', compact('items'));
   }
}
