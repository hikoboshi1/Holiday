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
					<select name="statuses" id="statuses" class="form-control col-sm-3">
						<option value=""></option>
						@foreach(\App\ApplicationStatuses::all() as $status)
						<option value="{{ $status->id }}">{{ $status->application_status_name }}</option>
						@endforeach
					</select>

	        		<label class="col-sm-1 text-center mt-2">種別</label>
          			<select id="types" name="types" class="form-control col-sm-3">
						<option value=""></option>
					 	@foreach(\App\HolidayType::all() as $type)
          				<option value="{{ $type->id }}" data-code="{{ $type->holiday_type_code }}" @if(old('types')== $type->id) selected @endif> {{ $type->holiday_type_name }} </option>
        				@endforeach 
          			</select>
				</div>

				@can('admin')
				<div class="row mt-2">
					<label class="col-sm-1 text-right mt-2">従業員</label>
					<select name="employees" id="employees" class="form-control col-sm-7">
						@foreach(\App\Employees::all() as $employee)
						<option id="employee" name="employee" value="{{ $employee->id }}">{{ $employee->last_name }}{{ $employee->first_name }}</option>
						@endforeach
					</select>
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
			<table border="1" class="table table-sm table-hover" style="table-layout:fixed;">
				<thead class="thead-light text-center">
					<tr>	
						<th scope="col" style="width:20%;">提出日</th>
						<th scope="col" style="width:20%;">休暇種別</th>
						<th scope="col" style="width:20%;">申請状況</th>
						<th scope="col" style="width:20%;"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($items as $item)
					<tr class="text-center">
						<td><span>{{ $item->submit_datetime->format('Y/m/d') }}</span></td>
						<td><span>{{ $item->holiday_type->holiday_type_name }}</span></td>
						<td><span>{{ \App\ApplicationStatuses::IdToName($item->application_status_id) }}</span></td>
						<td><a href="{{ route('holiday_show',['holidayApplication' => $item->id]) }}"><button type="submit" class="btn btn-primary" style="height:35px;" >詳細</button></a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection