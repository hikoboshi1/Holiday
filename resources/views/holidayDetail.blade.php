@extends('layouts.app')
@section('content')
<div class="container">
  <div class="section-header">
      <h3>休暇届：詳細</h3>
  </div>
  <div class="text-right">
    <a href="{{ session()->get('indexUrl') }}"><button class="btn btn-primary btn-fixedsize pull-right my-3" style="width:200px;">一覧へ戻る</button></a>
  </div>
  <div class="card">
    <div class="card-body">
    	<form id="edit">
        @csrf
        <div hidden><input name="holiday_id" value="{{ $holidayApplication->id }}"></div>
        @can('admin')
        <div class="row">
          <label class="col-sm-1 text-right">氏名</label>
          <input type="text" id="employee_name" name="employee_name" class="col-sm-3 form-control" value="{{ \App\Employees::IdToLastName($holidayApplication->employee_id) }}{{ \App\Employees::IdToFirstName($holidayApplication->employee_id) }}" readonly>
        </div>
        @endcan

        <div class="row mt-4">
          <label class="col-sm-1 text-right">種別</label>                   
          <input type="text" id="holiday_type" name="holiday_type" class="col-sm-3 form-control" value="{{ $holidayApplication->holiday_type->holiday_type_name }}" readonly/>
          <label class="col-sm-1 text-right">提出日</label>                
          <input type="text" id="submit_datetime"　name="submit_datetime" class="col-sm-3 form-control" value="{{ $holidayApplication->submit_datetime->format('Y/m/d') }}" readonly/>    
        </div>

        <div class="row mt-4">      
          <label class="col-sm-1 text-right">期間</label>
          <input type="text" id="date_from" name="date_from" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseDate($holidayApplication->holiday_date_from) }}" readonly/>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label>
          <input type="text" id="date_to" name="date_to" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseDate($holidayApplication->holiday_date_to) }}" readonly/>
          <input type="text" id="days" name="days" class="col-sm-2 ml-4 text-right form-control" value="{{ $holidayApplication->total_days }}" readonly/>
          <label class="col-sm-1">日間</label>    
        </div>
        <div class="row mt-4">        
          <label class="col-sm-1 text-right">時間</label>
          <input type="text" id="time_from" name="time_from" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseTime($holidayApplication->holiday_time_from) }}" readonly/>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label> 
          <input type="text" id="time_to" name="time_to" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseTime($holidayApplication->holiday_time_to) }}" readonly/>
          <input type="text" id="time" name="time" class="col-sm-2 ml-4 text-right form-control" readonly/>
          <label class="col-sm-1">時間</label>            
        </div>
        <div class="row mt-4">        
          <label class="col-sm-1 text-right">理由</label>
          <textarea id="reason" name="reason" class="col-sm-10 form-control" readonly>{{ $holidayApplication->reason }}</textarea>  
        </div>
        <div class="row mt-4 mb-2">        
          <label class="col-sm-1 text-right">備考</label>
          <textarea id="remarks" name="remarks" class="col-sm-10 form-control" readonly>{{ $holidayApplication->remarks }}</textarea>        
        </div>
        <div class="offset-sm-3">
          <button type="button" class="update btn btn-primary my-3 mr-4" style="width:200px;" data-href="{{ route('holiday_edit', $holidayApplication) }}">修正</button>
          <button type="button" class="delete btn btn-danger my-3" style="width:200px;" data-href="{{ route('holiday_delete', $holidayApplication) }}">取消</button>
        </div>
      </form>
      
    </div>
    

  </div>
</div>
@endsection