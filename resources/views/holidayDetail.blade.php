@extends('layouts.app')
@section('content')
<div class="container">
<div class="section-header">
    <h3>休暇届：詳細</h3>
</div>
<div class="text-right">
  <a href="{{ route('holiday_index') }}"><button class="btn btn-primary btn-fixedsize pull-right my-3" style="width:200px;">一覧へ戻る</button></a>
</div>
  <div class="card">
    <div class="card-body">
    	<form>
        @csrf
        @can('admin')
        <div class="row">
          <label class="col-sm-1 text-right">氏名</label>
          <input type="text" id="employee_name" name="employee_name" class="col-sm-3 form-control" value="{{ \App\Employees::IdToLastName($holidayData->employee_id) }}{{ \App\Employees::IdToFirstName($holidayData->employee_id) }}" readonly>
        </div>
        @endcan

        <div class="row mt-4">
          <label class="col-sm-1 text-right">種別</label>                   
          <input type="text" id="holiday_type" name="holiday_type" class="col-sm-3 form-control" value="{{ $holidayData->holiday_type->holiday_type_name }}" readonly/>
          <label class="col-sm-1 text-right">提出日</label>                
          <input type="text" id="submit_datetime"　name="submit_datetime" class="col-sm-3 form-control" value="{{ $holidayData->submit_datetime->format('Y/m/d') }}" readonly/>    
        </div>

        <div class="row mt-4">      
          <label class="col-sm-1 text-right">期間</label>
          <input type="text" id="date_from" name="date_from" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseDate($holidayData->holiday_date_from) }}" readonly/>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label>
          <input type="text" id="date_to" name="date_to" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseDate($holidayData->holiday_date_to) }}" readonly/>
          <input type="text" id="total_days" name="total_days" class="col-sm-2 ml-4 text-right form-control" value="{{ $holidayData->total_days }}" readonly/>
          <label class="col-sm-1">日間</label>    
        </div>
        <div class="row mt-4">        
          <label class="col-sm-1 text-right">時間</label>
          <input type="text" id="time_from" name="time_from" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseTime($holidayData->holiday_time_from) }}" readonly/>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label> 
          <input type="text" id="time_to" name="time_to" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseTime($holidayData->holiday_time_to) }}" readonly/>
          <input type="text" id="time" name="time" class="col-sm-2 ml-4 text-right form-control" readonly/>
          <label class="col-sm-1">時間</label>            
        </div>
        <div class="row mt-4">        
          <label class="col-sm-1 text-right">理由</label>
          <textarea id="reason" name="reason" class="col-sm-10 form-control" readonly>{{ $holidayData->reason }}</textarea>  
        </div>
        <div class="row mt-4 mb-2">        
          <label class="col-sm-1 text-right">備考</label>
          <textarea id="remarks" name="remarks" class="col-sm-10 form-control" readonly>{{ $holidayData->remarks }}</textarea>        
        </div>
      </form>
    </div>
  </div>
</div>
@endsection