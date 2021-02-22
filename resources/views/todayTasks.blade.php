@if(auth()->user()->type == 1)

	@extends('layouts.master')
	@section('title', 'Today\'s Tasks')
	@section('content')
	    @include('widgets.todayTasks')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif