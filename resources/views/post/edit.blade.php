@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<form action="{{ route('posts.update', $post->id) }}" method="POST">

    <div class="col-md-12">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="patch">
    </div>

    <div class="flex justify-content-center">
        <div class="col-md-6 form-group">
            <label>User Name</label>
            <select class="custom-select" name="user_id">
                @foreach ($users as $user)
                <option value="{{ $user->id }}" @if ($user->id == $post->user_id) selected @endif>{{ $user->name }}
                </option>
                @endforeach
            </select>
            @error('user_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-content-center">
        <div class="col-md-6 form-group">
            <label>Post Body</label>
            <textarea name="body" style="height: 100px;min-height: 100px;max-height: 150px"
                class="form-control">{{ $post->body }}</textarea>
            @error('body')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-content-center">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
