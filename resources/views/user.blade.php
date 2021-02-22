@if(auth()->user()->type == 1)

	@extends('layouts.master')

	@section('title', 'Users')

	@section('content')
	    @include('widgets.addUser')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif