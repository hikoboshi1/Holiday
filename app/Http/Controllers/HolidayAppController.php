<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayAppPostRequest;
use App\HolidayApplication;
use App\Http\Requests\SearchIndexReq;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HolidayAppController extends Controller
{
    //申請画面
    public function create()
    {
        return view('holidayApplication');
    }

    //新規申請
    public function store(HolidayAppPostRequest $req)
    {
        $holidayApp = new HolidayApplication();
        $params = $req->all();
        
        $holidayApp->employee_id = Auth::id();
        $holidayApp->submit_datetime = Carbon::now();
        $holidayApp->holiday_type_id = $params['types'];
        $holidayApp->holiday_date_from = $params['date_from'];
        if($params['types'] != '2'){
            $holidayApp->holiday_date_to = $params['date_to'];
        }
        $holidayApp->total_days = $params['days'];
        if($params['types'] == '2'){
            $holidayApp->holiday_time_from = $params['time_from'];
            $holidayApp->holiday_time_to = $params['time_to'];
        }
        $holidayApp->reason = $params['reason'];
        $holidayApp->remarks = $params['remarks'];
        $holidayApp->application_status_id = $holidayApp->application_status_id ?? 1;
        $holidayApp->save();
        
        return redirect('dcfportal/holiday_applications');       
    }

    //詳細画面
    public function detail($holidayApplication)
    {
       $holidayData = HolidayApplication::find($holidayApplication);
       return view('holidayDetail')->with('holidayData',$holidayData);
    }

    //一般:一覧 検索条件
    public function userSearch(SearchIndexReq $req)
    {
        $query = HolidayApplication::query();
        
        $status = $req->input('statuses');
        $type = $req->input('types');
        $from = $req->input('submit_from');
        $to = $req->input('submit_to');

        //検索:処理状況
        $query->when($status !== null, function($query) use ($status){
            return $query->where('application_status_id', $status);
        });
        //検索:種別
        $query->when($type !== null, function ($query) use ($type){
            return $query->where('holiday_type_id', $type);
        });
        //検索:提出期間指定があれば、その範囲に絞る
        if(!empty($from) && !empty($to)){
            return $query->whereBetween('submit_datetime',[$req->submit_from , $req->submit_to])->get();
        }
        //ログインしているユーザーと一致しているレコードを取得
        $index = $query->where('employee_id', '=', Auth::user()->id)->get();
        return $index;
    }
    //一般:一覧　検索
    public function index(SearchIndexReq $req)
    {
        $items = $this->userSearch($req);
        return view('holidayHome', compact('items'));
    }
    //一般:一覧 検索条件
    public function adminSearch(SearchIndexReq $req)
    {
        $query = HolidayApplication::query();
            
        $status = $req->input('statuses');
        $type = $req->input('types');
        $from = $req->input('submit_from');
        $to = $req->input('submit_to');
    
        //検索:処理状況
        $query->when($status !== null, function($query) use ($status){
            return $query->where('application_status_id', $status);
        });
        //検索:種別
        $query->when($type !== null, function ($query) use ($type){
            return $query->where('holiday_type_id', $type);
        });
        //検索:提出期間指定があれば、その範囲に絞る
        if(!empty($from) && !empty($to)){
            return $query->whereBetween('submit_datetime',[$req->submit_from , $req->submit_to])->get();
        }
        //ログインしているユーザーと一致しているレコードを取得
        $index = $query->where('employee_id', '=', Auth::user()->id)->get();
        return $index;
    }
    //一般:一覧　検索
    public function admin_holiday_index(SearchIndexReq $req)
    {
        $items = $this->adminSearch($req);
        return view('holidayHome', compact('items'));
    }
    

  /*  管理者:一覧
    public function admin_holiday_index(){
        return 'index';
    }*/

    //管理者:詳細
    public function admin_holiday_show(){
        return 'show';
    }

    //管理者:確定
    public function admin_holiday_confilm(){
        return 'confilm';
    }

    //管理者:確定取消
    public function admin_holiday_reject(){
        return 'reject';
    }
}
