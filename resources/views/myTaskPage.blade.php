@if(auth()->user()->type == 2)

    @extends('layouts.master')

	@section('title', 'My Task List')

	@section('content')
	    @include('widgets.submitMyTask')
	@endsection

@else 

<script>window.location = "/404";</script>
@endif