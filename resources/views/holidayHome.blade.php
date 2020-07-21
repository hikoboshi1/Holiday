@extends('layouts.app')
@section('content')
<div class="section-header">
    <h3>休暇届：一覧</h3>
</div>
<div class="container">
    <div class="card">
        <div class="card-body">               
			<table border="1" class="table table-sm table-hover" style="table-layout:fixed;">
				<thead class="thead-light text-center">
					<tr>	
						<th scope="col" style="width:20%;">提出日</th>
						<th scope="col" style="width:20%;">ユーザー名</th>
						<th scope="col" style="width:20%;">休暇種別</th>
						<th scope="col" style="width:20%;"></th>
					</tr>
				</thead>
				<tbody>
				@foreach($items as $item)
					<tr class="text-center">
						<td><span>{{ $item->submit_date->format('Y/m/d') }}</span></td>
						<td><span>{{ $item->user->name }}</span></td>
						<td><span>{{ $item->holiday_type->holiday_type_name }}</span></td>
						<td><a href="{{ route('show',['id' => $item->id]) }}"><button type="submit" class="btn btn-primary" style="height:35px;" >詳細</button></a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
        </div>
    </div>
</div>
@endsection