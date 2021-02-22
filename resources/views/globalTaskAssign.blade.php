@if(auth()->user()->type == 1)

	@extends('layouts.master')

	@section('title', 'Global Task Assign')

	@section('content')
	    @include('widgets.globalTaskAssignPage')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif