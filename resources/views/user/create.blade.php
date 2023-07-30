@extends('layouts.app')

@section('title', 'Create User')

@section('content')
@include('includes.alert')

@if (count($errors->createUserErrors) > 0)
<ul class="flex justify-center">
    <li class="text-danger">{{ $errors->createUserErrors->first('email') }}</li>
    <li class="text-danger">{{ $errors->createUserErrors->first('password') }}</li>
</ul>
@endif

<form action="{{ route('users.store') }}" method="POST">

    <div class="col-md-6">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>

    <div class="flex justify-center">
        <div class="col-md-6 form-group">
            <label>User Name</label>
            <input type="text" class="form-control" name="name"
                value="{{ old('name', 'default text for name input') }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-center">
        <div class="col-md-6 form-group">
            <label>Email address</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" name="email" value="{{ old('email') }}">

            <span class="text-danger">{{ $errors->createUserErrors->first('email') }}</span>
        </div>
    </div>

    <div class="flex justify-center">
        <div class="col-md-6 form-group">
            <label>Locale</label>
            <select class="form-control" name="locale">
                <option value="en">English</option>
                <option value="ar">Arabic</option>
            </select>
            @error('locale')
            <span class="text-danget"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="flex justify-center">
        <div class="col-md-6 form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
            {{-- you can also specify the name of the `Error Bag` by passing the second parameter of the `error`
            directive --}}
            @error('password', 'createUserErrors')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-center">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="d-flex justify-content-end" href="{{ route('users.index') }}">Show Users</a>
        </div>
    </div>
</form>
@endsection
