@extends('layouts.app')
@section('content')
<div class="section-header">
    <h3>休暇届：詳細</h3>
</div>
<div class="container">
  <div class="card">
    <div class="card-body">
    	<form>
        @csrf
        <div class="row mt-2">
          <label class="col-sm-1 text-right">種別</label>                   
          <input type="text" id="holiday_type" name="holiday_type" class="col-sm-3 form-control" value="{{ $holidayData->holiday_type->holiday_type_name }}" readonly/>
          <label class="col-sm-1 text-right">提出日</label>                
          <input type="text" id="submit_date"　name="submit_date" class="col-sm-3 form-control" value="{{ $holidayData->submit_date->format('Y/m/d') }}" readonly/>    
        </div>
        <div class="row mt-4">      
          <label class="col-sm-1 text-right">期間</label>
          <input type="text" id="date_start" name="date_start" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseDate($holidayData->holiday_date_from) }}" readonly/>
          <label class="col-sm-1 text-center"><font size="+1">～</font></label>
          <input type="text" id="date_end" name="date_end" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseDate($holidayData->holiday_date_to) }}" readonly/>
          <input type="text" id="dateSpan" name="dateSpan" class="col-sm-2 ml-4 text-right form-control" readonly/>
          <label class="col-sm-1">日間</label>    
        </div>
        <div class="row mt-4">        
          <label class="col-sm-1 text-right">時間</label>
          <input type="text" id="time_start" name="time_start" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseTime($holidayData->holiday_time_from) }}" readonly/>
          <label class="col-sm-1 text-center"><font size="+1">～</font></label> 
          <input type="text" id="time_end" name="time_end" class="col-sm-3 form-control" value="{{ \App\HolidayApplication::parseTime($holidayData->holiday_time_to) }}" readonly/>
          <input type="text" id="timeSpan" name="timeSpan" class="col-sm-2 ml-4 text-right form-control" readonly/>
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