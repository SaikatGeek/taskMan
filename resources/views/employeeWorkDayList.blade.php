@if(auth()->user()->type == 1)

	@extends('layouts.master')

	@section('title', 'Employee Work Day List')

	@section('content')
	    @include('widgets.employeeWorkDayList')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif