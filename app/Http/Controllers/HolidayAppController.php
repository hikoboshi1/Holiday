<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayAppPostRequest;
use App\HolidayApplication;
use App\Http\Requests\SearchIndexReq;
use Illuminate\Support\Facades\Auth;
use App\Services\HolidayAppService;
use App\Services\HolidaySpanService;
use illuminate\Http\Request;

class HolidayAppController extends Controller
{
    protected $holidayAppService;
    protected $holidaySpanService;

    public function __construct(HolidayAppService $holidayAppService, HolidaySpanService $holidaySpanService)
    {
        $this->holidayAppService = $holidayAppService;
        $this->holidaySpanService = $holidaySpanService;
    }

    //申請画面
    public function create(Holidayapplication $holidayApplication)
    {
        $mode = 'new';
        return view('holidayApplication', compact('holidayApplication', 'mode'));
    }

    //新規申請
    public function store(HolidayAppPostRequest $req)
    {
        $params = $req->all();
        $this->holidayAppService->storeHoliday($params);
        
        return redirect('dcfportal/holiday_applications');       
    }

    //一般 & 管理者:一覧
    public function index(SearchIndexReq $req)
    {
        $reqUrl = $req->fullUrl();
        $req->session()->put('indexUrl', $reqUrl);
        $holidayApplications = $this->holidayAppService->searchIndex($req);
        
        $holidayApplications->transform(function ($holidayApplication){
            if (Auth::user()->role->role_code === 'user') {
                return [
                    $holidayApplication->submit_datetime->format('yy-m-d'),
                    $holidayApplication->holiday_type->holiday_type_name,
                    $holidayApplication->holiday_date_from,
                    $holidayApplication->application_status->application_status_name,
                    route('holiday_show', $holidayApplication->id),
                ];
            }
            else{
                return[
                    $holidayApplication->submit_datetime->format('yy-m-d'),
                    $holidayApplication->employee->last_name . $holidayApplication->employee->first_name,
                    $holidayApplication->holiday_type->holiday_type_name,
                    $holidayApplication->holiday_date_from,
                    $holidayApplication->application_status->application_status_name,
                    route('holiday_show', $holidayApplication->id),
                ];
            }
        });
        $holidayApplications = json_encode($holidayApplications);
       
        return view('holidayHome', compact('holidayApplications'));
    }
   
    //詳細画面
    public function detail(HolidayApplication $holidayApplication)
    {
        // $holidayData = HolidayApplication::find($holidayApplication);
        return view('holidayDetail',compact('holidayApplication'));
    }

    //休暇申請削除
    public function delete(HolidayApplication $holidayApplication)
    {
        //詳細を見てるholidayApplicationインスタンスのidを取得
        $params = $holidayApplication->id;
        $employeeId = $holidayApplication->employee_id;
        //一致してたら削除
        
        if (Auth::user()->employee_id == $employeeId) { //うまくいっていない
            HolidayApplication::where('id', $params)->delete();
        }else{
            abort(403);
        }
        return redirect('dcfportal/holiday_applications');
    }

    //修正画面
    public function edit(HolidayApplication $holidayApplication)
    {
        
        $employeeId = $holidayApplication->employee_id;
        $mode = 'edit';
        if (Auth::user()->employee_id == $employeeId) { //うまくいっていない
            return view('holidayApplication', compact('holidayApplication', 'mode'));
        }else{
            abort(403);
        }
    }

    //Ajaxで合計日数を返す
    public function duration(Request $req){
        $from = $req->all();
        $to = $req->all();
        $days = $this->holidaySpanService->getDuration($from, $to);
        return $days;
    }
}
