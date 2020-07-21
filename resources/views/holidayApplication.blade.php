@extends('layouts.app')
@section('content')
<div class="section-header">
    <h3>休暇届：新規</h3>
</div>
<div class="container ">
  @if(count($errors) > 0)
    <div class="errormessagebox">
      <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
	<form action="{{ url('/new') }}" method="post">
    <div class="card">
    	<div class="card-body">
        @csrf
        <div class="row mt-2">
          <label class="col-sm-1 text-right" >種別</label>
          <select name="types" id="types" class="col-sm-3">
            @foreach(\App\HolidayType::all() as $type)
              <option id="type" name="type" value="{{ $type->id }}" data-code="{{ $type->holiday_type_code }}" @if(old('types')== $type->id) selected @endif> {{ $type->holiday_type_name }} </option>
            @endforeach 
          </select>
          <label class="col-sm-1 text-right">提出日</label>                
					<input id="submit_date" name="submit_date" type="text" class="col-sm-3" value="{{ \Carbon\Carbon::now()->format('Y/m/d') }}" readonly/>
        </div>
        <div class="row mt-4">
          <label class="col-sm-1 text-right">期間</label>
					<input id="date_from" name="date_from" type="text" class="col-sm-3" value="{{ old('date_from') }}" class="@error('date_from') is-invalid @enderror"/>
          <label class="col-sm-1 text-center" ><font size="+1">～</font></label>
          <input id="date_to" name="date_to" type="text" class="col-sm-3" value="{{ old('date_to') }}" class="@error('date_to') is-invalid @enderror"/>
          <input id="date" name="date" type="text" class="col-sm-2 ml-4 text-right" value="{{ old('date') }}"/>
          <label class="col-sm-1">日間</label>
        </div>
        <div class="row mt-4">
          <label for="time" class="col-sm-1 text-right">時間</label>
          <select id="time_from" name="time_from" class="col-sm-3" class="@error('time_from') is-invalid @enderror" data-old="{{ old('time_from') }}"><option placeholder=""></option></select>
          <label class="col-sm-1 text-center"><font size="+1">～</font></label> 
          <select id="time_to" name="time_to" class="col-sm-3" class="@error('time_to') is-invalid @enderror" data-old="{{ old('time_to') }}"><option placeholder="" ></option></select>
          <input id="time" name="time" type="text" class="col-sm-2 ml-4" style="text-align:right" value="{{ old('time') }}"/>
          <label class="col-sm-1">時間</label>
        </div>
        <div class="row mt-4">
          <label for="reason" class="col-sm-1 text-right">理由</label>
					<textarea id="reason" name="reason" rows="4" class="col-sm-10" class="@error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
        </div>
        <div class="row mt-4">         
          <label for="remarks" class="col-sm-1 text-right">備考</label>
          <textarea id="remarks" name="remarks" rows="4" class="col-sm-10"></textarea>
        </div>
    	</div>
		</div>
    <div class="text-center">
      <button type="submit" style="width:200px" class="btn btn-primary col sm-1">申請</button>      
		</div>
  </form>    
</div>

@endsection('content')