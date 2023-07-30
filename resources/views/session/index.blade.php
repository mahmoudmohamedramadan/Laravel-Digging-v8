@extends('layouts.app')

@section('title', 'Session')

@section('content')
<div class="col-md-8">
    @if (session()->exists('welcomeMsg') and session()->has('welcomeMsg'))
    <strong>print with get method </strong>
    {{ session()->get('welcomeMsg', function () {
    return 'this will appears in case of there is NO value for `welcomeMsg` key, BUT does not work i do not know why
    ?!😂';
    }) }}
    @endif
</div>
@stop
