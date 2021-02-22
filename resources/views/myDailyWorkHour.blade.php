@if(auth()->user()->type == 2)

    @extends('layouts.master')

    @section('title', 'My Daily Work Hours')

    @section('content')
        @include('widgets.myDailyWorkHour')
    @endsection

@else 

<script>window.location = "/404";</script>
@endif