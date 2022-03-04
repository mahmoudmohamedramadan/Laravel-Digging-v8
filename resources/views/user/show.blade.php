@extends('layouts.app')

@section('title', 'Show User')

@section('content')
<div class="flex justify-center">
    <div class="col-md-6 form-group">
        <label for="inputName">User Name</label>
        <input type="text" class="form-control" id="inputName" name="name" value="{{ $user->name }}">
        @error('name')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="flex justify-center">
    <div class="col-md-6 form-group">
        <label>Email address</label>
        <input type="text" class="form-control" name="email" value="{{ $user->email }}">
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="flex justify-center">
    <div class="col-md-6 form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" value="{{ $user->password }}">
        @error('password')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
@endsection
