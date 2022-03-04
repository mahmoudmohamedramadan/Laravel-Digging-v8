@extends('layouts.app')

@section('title', 'Session | Laravel Digging')

@section('content')

<div class="col-md-8">
    @if (session()->exists('welcomeMsg') and session()->has('welcomeMsg'))
    <strong>print WITH get method </strong>
    {{ session()->get('welcomeMsg', function () {
    return 'this will appears in case of there is NO value for `welcomeMsg` key, BUT does NOT work i do NOT know why ?!😂';
}) }}
    @endif

</div>

@stop
