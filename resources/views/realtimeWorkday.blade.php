@if(auth()->user()->type == 1)

	@extends('layouts.master')
	@section('title', 'Realtime Work Hours')
	@section('content')
	    @include('widgets.realtimeWorkDay')
	@endsection

@else
  <script>window.location = "/404";</script>
@endif