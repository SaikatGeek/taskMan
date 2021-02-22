@if(auth()->user()->type == 1)

	@extends('layouts.master')
	@section('title', 'Projects')
	@section('content')
	    @include('widgets.projectDescribe')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif