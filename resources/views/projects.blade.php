@if(auth()->user()->type == 1)
	@extends('layouts.master')

	@section('title', 'Projects')

	@section('content')
	    @include('widgets.addProject')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif