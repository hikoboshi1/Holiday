@extends('layouts.app')
@section('content')
<div class="container">
  <div class="section-header">
      <h3>休暇届：修正</h3>
  </div>
  <div class="text-right">
    <a href="{{ route('holiday_show',['holidayApplication' => $holidayApplication->id]) }}"><button class="btn btn-primary btn-fixedsize pull-right my-3" style="width:200px;">詳細へ戻る</button></a>
  </div>
  <div class="card">
    <div class="card-body">
    	<form action="get">
        @csrf
        @can('admin')
        <div class="row">
          <label class="col-sm-1 text-right">氏名</label>
          <input type="text" id="employee_name" name="employee_name" class="col-sm-3 form-control" value="{{ \App\Employees::IdToLastName($holidayApplication->employee_id) }}{{ \App\Employees::IdToFirstName($holidayApplication->employee_id) }}">
        </div>
        @endcan

        <div class="row mt-4">
          <label class="col-sm-1 text-right">種別</label>                   
          <select name="types" id="types" class="col-sm-3">
            @foreach(\App\HolidayType::all() as $type)
              <option id="type" name="type" value="{{ $type->id }}" data-code="{{ $type->holiday_type_code }}" @if(old('type', $holidayApplication->holiday_type->id)== $type->id) selected @endif> {{ $type->holiday_type_name }} </option>
            @endforeach 
          </select>
          <label class="col-sm-1 text-right">提出日</label>                
          <input type="text" id="submit_datetime"　name="submit_datetime" class="col-sm-3 form-control" value="{{ $holidayApplication->submit_datetime->format('Y/m/d') }}"/>    
        </div>

        <div class="row mt-4">      
          <label class="col-sm-1 text-right">期間</label>
          <input type="text" id="date_from" name="date_from" class="col-sm-3 form-control calendar" value="{{ \App\HolidayApplication::parseDate($holidayApplication->holiday_date_from) }}"/>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label>
          <input type="text" id="date_to" name="date_to" class="col-sm-3 form-control calendar" value="{{ \App\HolidayApplication::parseDate($holidayApplication->holiday_date_to) }}"/>
          <input type="text" id="total_days" name="total_days" class="col-sm-2 ml-4 text-right form-control" value="{{ $holidayApplication->total_days }}"/>
          <label class="col-sm-1">日間</label>    
        </div>
        <div class="row mt-4">
          <label for="time" class="col-sm-1 text-right">時間</label>
          <select id="time_from" name="time_from" class="col-sm-3 timepicker @error('time_from') is-invalid @enderror" data-old="{{ old('time_from') }}">
              <option placeholder="">{{ \App\HolidayApplication::parseTime($holidayApplication->holiday_time_from) }}</option>
          </select>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label> 
          <select id="time_to" name="time_to" class="col-sm-3 timepicker @error('time_to') is-invalid @enderror" data-old="{{ old('time_to') }}">
              <option placeholder="" >{{ \App\HolidayApplication::parseTime($holidayApplication->holiday_time_to) }}</option>
          </select>
          <input id="time" name="time" type="text" class="col-sm-2 ml-4" style="text-align:right" value="{{ old('time') }}" readonly/>
          <label class="col-sm-1">時間</label>
        </div>
        <div class="row mt-4">        
          <label class="col-sm-1 text-right">理由</label>
          <textarea id="reason" name="reason" class="col-sm-10 form-control">{{ $holidayApplication->reason }}</textarea>  
        </div>
        <div class="row mt-4 mb-2">        
          <label class="col-sm-1 text-right">備考</label>
          <textarea id="remarks" name="remarks" class="col-sm-10 form-control">{{ $holidayApplication->remarks }}</textarea>        
        </div>
        <div class="col-sm-2 offset-sm-5">
            <button class="btn btn-primary btn-fixedsize pull-right my-3" style="width:200px;">更新</button>
        </div>  
    </form>
    </div>
  </div>
</div>
@endsection