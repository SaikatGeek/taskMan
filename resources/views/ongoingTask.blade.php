@if(auth()->user()->type == 1)

	@extends('layouts.master')
	@section('title', 'Ongoing Tasks')
	@section('content')
	    @include('widgets.ongoingTask')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif