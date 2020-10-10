@extends('layouts.app')

@section('content')
<div class="container ">
	<div class="section-header">
		<h3>休暇申請一覧</h3>
	</div>

	<form id="searchIndex">
		<div class="card">
    		<div class="card-body">
				@csrf
        		<div class="row mt-2">
					<label class="col-sm-1 text-right mt-2">申請状況</label>
					<select name="status" id="status" class="form-control col-sm-3">
						<option value=""></option>
						@foreach(\App\ApplicationStatuses::all() as $status)
						<option value="{{ $status->id }}">{{ $status->application_status_name }}</option>
						@endforeach
					</select>

	        		<label class="col-sm-1 text-center mt-2">種別</label>
          			<select id="type" name="type" class="form-control col-sm-3">
						<option value=""></option>
					 	@foreach(\App\HolidayType::all() as $type)
          				<option value="{{ $type->id }}" data-code="{{ $type->holiday_type_code }}" @if(old('types')== $type->id) selected @endif> {{ $type->holiday_type_name }} </option>
        				@endforeach 
          			</select>
				</div>

				@can('admin')
				<div class="row mt-2">
					<label class="col-sm-1 text-right mt-2">従業員</label>
					<input type="text" name="employee" id="employee" class="form-control col-sm-7">
				</div>
				@endcan

			<div class="row mt-2">
				<label class="col-sm-1 text-right mt-2">提出期間</label>                
				<input id="submit_from" name="submit_from" type="text" class="form-control col-sm-3 calendar"/>
				<label class="col-sm-1 text-center mt-2" style="font-size:130%;">～</label>
				<input id="submit_to" name="submit_to" type="text" class="form-control col-sm-3 calendar"/>			  
				<button type="submit" class="form-control btn btn-primary ml-5" style="width:200px">検索</button>
			</div>
    	</div>
	</div>
</form>
</div>

<div class="container">	
	<div class="card">
		<div class="card-body"> 
			@if(Auth::user()->role->role_code === 'user')
			<table id="userTable" class="table table-sm table-hover" data-title="提出日,休暇種別,休暇日,申請状況,詳細" data-widths='["25%","20%","25%","20%","10%"]' data-json="{{ $holidayApplications }}" style="table-layout:fixed;">	
			</table>
			@else
			<table id="adminTable" class="table table-sm table-hover" data-title="提出日,従業員氏名,休暇種別,休暇日,申請状況,詳細" data-widths='["20%","20%","15%","20%","15%","10%"]' data-json="{{ $holidayApplications }}" style="table-layout:fixed;">	
			</table>
			@endif
		</div>
	</div>
</div>
@endsection