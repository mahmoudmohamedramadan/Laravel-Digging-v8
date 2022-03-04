@extends('layouts.app')

@section('title', 'Trashed Users')

@section('content')

<table class="table table-striped text-center">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td><a href="{{ route('users.forceDelete', $user->id) }}" target="_blanck">{{ $user->id }}</a>
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('users.forceDelete', $user->id) }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-warning"
                        onclick="location.href='{{ route('users.restore', $user->id) }}'">
                        Restore
                    </button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
