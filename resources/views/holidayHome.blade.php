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
						<option value="{{ old($status->id) }}">{{ $status->application_status_name }}</option>
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
				<input id="submit_from" name="submit_from" type="text" class="form-control col-sm-3"/>
				<label class="col-sm-1 text-center mt-2" style="font-size:130%;">～</label>
				<input id="submit_to" name="submit_to" type="text" class="form-control col-sm-3"/>			  
				<button type="submit" class="form-control btn btn-primary ml-5" style="width:200px">検索</button>
			</div>
    	</div>
	</div>
</form>
</div>

<div class="container">	
	<div class="card">
		<div class="card-body"> 
			<table class="table table-sm table-hover" style="table-layout:fixed;">
				<thead class="thead-light text-center">
					<tr>
						<th scope="col" style="width:20%;">提出日</th>
						@can('admin')
						<th scope="col" style="width:20%;">従業員</th>
						@endcan
						<th scope="col" style="width:20%;">休暇種別</th>
						<th scope="col" style="width:20%;">休暇日</th>
						<th scope="col" style="width:20%;">申請状況</th>
						<th scope="col" style="width:20%;"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($holidayApplications as $holidayApplication)
					<tr class="text-center">
						<td><span>{{ $holidayApplication->submit_datetime->format('Y/m/d') }}</span></td>
						@can('admin')
						<td><span>{{ \App\Employees::IdToLastName($holidayApplication->employee_id) . \App\Employees::IdToFirstName($holidayApplication->employee_id) }}</span></td>
						@endcan	
						<td><span>{{ $holidayApplication->holiday_type->holiday_type_name }}</span></td>
						<td><span>{{ $holidayApplication->holiday_date_from }}</span></td>
						<td><span>{{ \App\ApplicationStatuses::IdToName($holidayApplication->application_status_id) }}</span></td>
						<td><a href="{{ route('holiday_show',['holidayApplication' => $holidayApplication->id]) }}"><button type="submit" class="btn btn-primary" style="height:35px;" >詳細</button></a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection