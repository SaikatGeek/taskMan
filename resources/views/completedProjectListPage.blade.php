@if(auth()->user()->type == 1)

	@extends('layouts.master')

	@section('title', 'Completed Project List')

	@section('content')
	    @include('widgets.completedProjectListPage')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif