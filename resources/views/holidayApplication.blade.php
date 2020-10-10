@extends('layouts.app')
@section('content')
<div class="container ">
  @if($mode == 'new')
  <div class="section-header">
    <h3>休暇届：新規</h3>
  </div>
  @else
  <div class="section-header">
    <h3>休暇届：修正</h3>
  </div>
  @endif
  <div class="text-right">
    <a href="{{ route('holiday_index') }}"><button class="btn btn-primary my-3" style="width:200px;">一覧へ戻る</button></a>
  </div>
  @if(count($errors) > 0)
  <div class="errormessagebox">
    <ul class="alert alert-danger">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
	<form action="{{ route('holiday_store') }}" method="post">
    <div class="card">
    	<div class="card-body">
        @csrf
        <div hidden><input name="holiday_id" value="{{ $holidayApplication->id }}" data-mode="{{ $mode }}"></div>
        <div class="row mt-2">
          <label class="col-sm-1 text-right" >種別</label>
          <select name="types" id="types" class="col-sm-3">
            @foreach(\App\HolidayType::all() as $type)
              <option id="type" name="type" value="{{ $type->id }}"
                data-code="{{ $type->holiday_type_code }}" @if(old('type', $holidayApplication->holiday_type_id)== $type->id) selected @endif>
                {{ $type->holiday_type_name }}
              </option>
            @endforeach 
          </select>
          <label class="col-sm-1 text-right">提出日</label>                
					<input id="submit_datetime" name="submit_datetime" type="text" class="col-sm-3" value="{{ \Carbon\Carbon::now()->format('Y/m/d') }}" readonly/>
        </div>
        <div class="row mt-4">
          <label class="col-sm-1 text-right">期間</label>
					<input id="holiday_date_from" name="holiday_date_from" type="text" class="col-sm-3 calendar @error('holiday_date_from') is-invalid @enderror" value="{{ old('holiday_date_from', \App\HolidayApplication::parseDate($holidayApplication->holiday_date_from)) }}"/>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label>
          <input id="holiday_date_to" name="holiday_date_to" type="text" class="col-sm-3 calendar @error('holiday_date_to') is-invalid @enderror" value="{{ old('holday_date_to', \App\HolidayApplication::parseDate($holidayApplication->holiday_date_to)) }}"/>
          <input id="total_date" name="total_date" type="text" class="col-sm-2 ml-4 text-right" value="{{ old('total_date', $holidayApplication->total_days) }}" readonly/>
          <label class="col-sm-1">日間</label>
        </div>
        <div class="row mt-4">
          <label for="time" class="col-sm-1 text-right">時間</label>
          <select id="time_from" name="time_from" class="col-sm-3 timepicker @error('time_from') is-invalid @enderror" data-old="{{ old('time_from', \App\HolidayApplication::parseTime($holidayApplication->holiday_time_from)) }}"><option placeholder=""></option></select>
          <label class="col-sm-1 text-center" style="font-size:130%;">～</label> 
          <select id="time_to" name="time_to" class="col-sm-3 timepicker @error('time_to') is-invalid @enderror" data-old="{{ old('time_to', \App\HolidayApplication::parseTime($holidayApplication->holiday_time_to)) }}"><option placeholder="" ></option></select>
          <input id="time" name="time" type="text" class="col-sm-2 ml-4" style="text-align:right" value="{{ old('time') }}" readonly/>
          <label class="col-sm-1">時間</label>
        </div>
        <div class="row mt-4">
          <label for="reason" class="col-sm-1 text-right">理由</label>
					<textarea id="reason" name="reason" rows="4" class="col-sm-10" class="@error('reason') is-invalid @enderror">{{ old('reason', $holidayApplication->reason) }}</textarea>
        </div>
        <div class="row mt-4">         
          <label for="remarks" class="col-sm-1 text-right">備考</label>
          <textarea id="remarks" name="remarks" rows="4" class="col-sm-10">{{ old('remarks', $holidayApplication->remarks) }}</textarea>
        </div>
    	</div>
    </div>
    @if($mode == 'new')
    <div class="text-center">
      <button type="submit" style="width:200px" class="btn btn-primary col sm-1">申請</button>      
    </div>
    @else
    <div class="text-center">
      <button type="submit" style="width:200px" class="btn btn-primary col sm-1">更新</button>      
    </div>
    @endif
  </form>    
</div>

@endsection('content')