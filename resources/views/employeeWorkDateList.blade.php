@if(auth()->user()->type == 1)

	@extends('layouts.master')
	@section('title', 'Employee Work Date List')
	@section('content')
	    @include('widgets.employeeWorkDateList')
	@endsection

@else
	<script>window.location = "/404";</script>
@endif