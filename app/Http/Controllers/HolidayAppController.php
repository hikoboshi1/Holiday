<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayAppPostRequest;
use Illuminate\Http\Request;
use App\HolidayApplication;
use Illuminate\Support\Facades\Auth;

class HolidayAppController extends Controller
{
    //
    public function create()
    {
        return view('holidayApplication');
    }
    public function store(HolidayAppPostRequest $req)
    {
        $holidayApp = new HolidayApplication();
        $params = $req->all();
        
        $holidayApp->user_id = Auth::user()->id;
        $holidayApp->submit_date = $params['submit_date'];
        $holidayApp->holiday_type_id = $params['types'];
        $holidayApp->holiday_date_from = $params['date_from'];
        if($params['types'] != '2'){
            $holidayApp->holiday_date_to = $params['date_to'];
        }
        if($params['types'] == '2'){
            $holidayApp->holiday_time_from = $params['time_from'];
            $holidayApp->holiday_time_to = $params['time_to'];
        }
        $holidayApp->reason = $params['reason'];
        $holidayApp->remarks = $params['remarks'];
        $holidayApp->save();
        
        return redirect('/index');       
    }
}
