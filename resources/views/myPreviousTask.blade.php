@if(auth()->user()->type == 2)

    @extends('layouts.master')

    @section('title', 'My Previous Task List')

    @section('content')
        @include('widgets.myPreviousTask')
    @endsection

@else 

<script>window.location = "/404";</script>
@endif