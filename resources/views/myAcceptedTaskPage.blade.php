@extends('layouts.master')
@if(Auth::user()->type == 1)
    @section('title', 'All Accepted Task List')
@else
    @section('title', 'My Accepted Task List')
@endif

@section('content')
    @include('widgets.myAcceptedTask')
@endsection
