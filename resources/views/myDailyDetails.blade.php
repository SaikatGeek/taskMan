@if(auth()->user()->type == 2)

    @extends('layouts.master')

    @section('title', 'My Daily Work Day Details')

    @section('content')
        @include('widgets.myDailyDetails')
    @endsection

@else 

<script>window.location = "/404";</script>
@endif