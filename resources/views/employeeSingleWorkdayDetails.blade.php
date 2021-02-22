@if(auth()->user()->type == 1)

	@extends('layouts.master')

	@section('title', 'Employee Single Day Details')

	@section('content')
	    @include('widgets.employeeSingleWorkdayDetails')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif