@extends('layouts.app')

@section('title', 'Session')

@section('content')
<div class="col-md-8">
    @if (session()->exists('welcomeMsg') and session()->has('welcomeMsg'))
    <strong>print with get method </strong>
    @php
    echo session()->get('welcomeMsg', function () {
    return 'This will appears in case of there is no value for `welcomeMsg` key';
    });
    @endphp
    @endif
</div>
@stop