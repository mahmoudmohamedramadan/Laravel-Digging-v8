@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<form action="{{ route('posts.store') }}" method="POST">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
    </div>

    @if (session()->has('success'))
    <div class="flex justify-center">
        <div class="col-md-6">
            <button class="btn btn-lg btn-block btn-outline-success mb-2">
                {{ session()->get('success') }}
            </button>
        </div>
    </div>
    @endif

    <div class="flex justify-content-center">
        <div class="col-md-6 form-group">
            <label>User Name</label>
            <select class="custom-select" name="user_id">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-content-center">
        <div class="col-md-6 form-group">
            <label>Post Title</label>
            <input type="text" name="title" class="form-control">
            @error('title')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-content-center">
        <div class="col-md-6 form-group">
            <label>Post Body</label>
            <textarea name="body" style="height: 100px;min-height: 100px;max-height: 150px"
                class="form-control"></textarea>
            @error('body')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-content-center">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class="d-flex justify-content-end" href="{{ route('posts.index') }}">Show Posts</a>
        </div>
    </div>
</form>
@endsection
