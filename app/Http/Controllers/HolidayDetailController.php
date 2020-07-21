<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayApplication;

class HolidayDetailController extends Controller
{
    //
    public function detail($holidayApplication)
    {
       $holidayData = HolidayApplication::find($holidayApplication);
       return view('holidayDetail')->with('holidayData',$holidayData);
    }
}
