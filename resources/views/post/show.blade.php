@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<div class="flex justify-content-center">
    <div class="col-md-6 form-group">
        <label>User Name</label>
        <input type="text" class="form-control" name="name" value="{{ $post->user->name }}" readonly>
    </div>
</div>

<div class="flex justify-content-center">
    <div class="col-md-6 form-group">
        <label>Post Title</label>
        <input type="text" class="form-control" name="title" value="{{ $post->title }}" readonly>
    </div>
</div>

<div class="flex justify-content-center">
    <div class="col-md-6 form-group">
        <label>Post Body</label>
        <textarea name="body" style="height: 100px;min-height: 100px;max-height: 100px" class="form-control"
            readonly>{{ $post->body }}</textarea>
    </div>
</div>


<div style="overflow-y: scroll; max-height: 300px">
    <form action="{{ route('comments.store', $post->id) }}" method="POST">
        @csrf

        <div class="flex justify-content-center" style="margin-top: 10px">
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

        <div class="flex justify-content-center" style="margin-top: 10px">
            <div class="col-md-6 form-group">
                <label>New Comment</label>
                <textarea placeholder="Type comment here" name="body"
                    style="height: 100px;min-height: 100px;max-height: 150px"
                    class="form-control">{{ old('body') }}</textarea>
                @error('body')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex justify-content-center">
            <div class="col-md-6 form-group">
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </div>
        </div>
    </form>

    <h3 class="flex justify-content-center">Comments</h3>

    <div class="flex justify-content-center" style="margin-top: 10px">
        <div class="col-md-6">
            @foreach ($comments as $comment)
            @if ($comment->user)
            <div style="background-color: #404040;color: #FFF;padding: 10px; margin-bottom: 10px">
                <form action="{{ route('comments.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}}"
                    method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger" style="float: right;margin-left: 10px">
                        Delete
                    </button>
                    <button type="button" class="btn btn-warning" style="float: right"
                        onclick="document.getElementsByClassName('comment_body_{{ $comment->id }}')[0].hidden=!document.getElementsByClassName('comment_body_{{ $comment->id }}')[0].hidden">
                        Edit
                    </button>
                </form>
                <h5>{{ $comment->user->name }}</h5>
                <span>{{ $comment->body }}</span>
                <form action="{{ route('comments.update', ['post' => $post->id, 'comment' => $comment->id]) }}"
                    method="POST" class="comment_body_{{ $comment->id }}" hidden>
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <textarea placeholder="Type comment here" name="body"
                            style="height: 100px;min-height: 100px;max-height: 150px"
                            class="form-control">{{ $comment->body }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
