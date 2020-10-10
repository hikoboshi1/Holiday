<?php

namespace App\Services;

use DB;
use App\HolidayApplication;
use App\Employees;
use App\Http\Requests\SearchIndexReq;
use Carbon\Carbon;
use Auth;

class HolidayAppService{
    //新規申請
    public function storeHoliday($params)
    {
        DB::transaction(function()use($params){
            $holidayApp = HolidayApplication::findOrNew($params['holiday_id']);
            $holidayApp->employee_id = Auth::user()->employee_id;
            $holidayApp->submit_datetime = Carbon::now();
            $holidayApp->holiday_type_id = $params['types'];
            $holidayApp->holiday_date_from = $params['holiday_date_from'];
            if($params['types'] != '2'){
                $holidayApp->holiday_date_to = $params['holiday_date_to'];
                $holidayApp->holiday_time_from = null;
                $holidayApp->holiday_time_to = null;
            }
            $holidayApp->total_days = $params['total_date'];
            if($params['types'] == '2'){
                $holidayApp->holiday_data_to = null;
                $holidayApp->holiday_time_from = $params['time_from'];
                $holidayApp->holiday_time_to = $params['time_to'];
            }
            $holidayApp->reason = $params['reason'];
            $holidayApp->remarks = $params['remarks'];
            $holidayApp->application_status_id = $holidayApp->application_status_id ?? 1;
            
            if ($params['holiday_id'] == null || Auth::user()->employee_id == $holidayApp->employee_id) {
                $holidayApp->save();
            }else{
                abort(500);
            }
        });
        
    }

    //一覧検索条件
    public function searchIndex(SearchIndexReq $req)
    {
        $query = HolidayApplication::query();

        //悪意を持って、アドレスバーに employee=名前 を入力したときに検索されてしまう 
        $status = $req->input('status');
        $type = $req->input('type');
        $employeeName = $req->input('employee');
        $from = $req->input('submit_from');
        $to = $req->input('submit_to');

        $employees = Employees::whereConcat($employeeName)->get();
        $employeeIds = $employees->map(function($employee){
            return $employee->id;
        });

        //検索:処理状況
        $query->when($status !== null, function($query) use ($status){
            return $query->where('application_status_id', $status);
        });
        //検索:種別
        $query->when($type !== null, function ($query) use ($type){
            return $query->where('holiday_type_id', $type);
        });
        //検索:従業員名　完全一致 ifでパラメータ入力検索できなくする
        if(Auth::user()->role_id === 1){
            $query->when($employeeName !== null, function ($query) use ($employeeIds) {
                return $query->whereIn('employee_id', $employeeIds);
            });
        }

        //検索:提出期間指定があれば、その範囲に絞る
        if(!empty($from) && !empty($to)){
            return $query->whereBetween('submit_datetime',[$req->submit_from , $req->submit_to])->get();
        }
        //従業員ログイン→ログインユーザーと一致しているレコードを取得
        //管理者ログイン→全従業員レコードを取得
        if (Auth::user()->role_id === 2) {
            $index = $query->where('employee_id', '=', Auth::user()->id)->get();
        }else{
            $index = $query->get();
        }
        return $index;
    }
    /*public function getDuration($params)
    {
        $fromdate = new Carbon($params['date_from']);
        $todate = new Carbon($params['date_to']);
        $period = CarbonPeriod::create($fromdate, $todate);
        $days = 0;
        if ($fromdate <= $todate) {
            foreach ($period as $date) {
                if (($date->dayOfWeek != 0) && ($date->dayOfWeek != 6)) {
                    $days++;
                }
            }
        } else {
            $days = "エラー";
        }
        return $days;
    }*/
}