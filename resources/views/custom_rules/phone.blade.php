@extends('layouts.app')

@section('title', 'Custom Rule')

@section('content')
<form action="{{ url('custom-rule-custom-request') }}" method="POST">
    
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
    </div>

    <div class="row flex justify-center">
        <div class="col-md-6">
            @if(session()->has('success'))
            <div class="alert alert-success text-center">{{ session()->get('success') }}</div>
            @endif
        </div>
    </div>

    <div class="row flex justify-center">
        <div class="col-md-6">
            <div class="form-group">
                <label>Number Phone</label>
                <input type="text" class="form-control" name="number" value="{{ old('number') }}">
                @error('number')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row flex justify-center">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@stop
