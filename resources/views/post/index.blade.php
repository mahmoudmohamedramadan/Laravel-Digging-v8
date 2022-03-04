@extends('layouts.app')

@section('title', 'Show All Posts')

@section('content')
<table class="table table-striped text-center">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Post</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <td><a href="{{ route('posts.show', $post->id) }}" target="_blanck">{{ $post->id }}</a></td>
            @if ($post->user)
            <td>{{ $post->user->name }}</td>
            @else
            <td>None</td>
            @endif

            <td>{{ $post->body }}</td>
            <td>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-warning" style="width: 70px"
                        onclick="location.href='{{ route('posts.edit', $post->id) }}'">
                        Edit
                    </button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
