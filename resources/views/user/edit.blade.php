@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
    <div class="col-md-12">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PATCH">
    </div>

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
            <label>Locale</label>
            <select class="form-control" name="locale">
                <option value="en" @if($user->locale=='en') selected @endif>English</option>
                <option value="ar" @if($user->locale=='ar') selected @endif>Arabic</option>
            </select>
            @error('locale')
            <span class="text-danget"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    @can('update-user', $user)
    <div class="flex justify-center">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    @endcan

    @cannot('update-user', $user)
    <h3>You are not allow to update this user</h3>
    @endcannot
</form>
@endsection
