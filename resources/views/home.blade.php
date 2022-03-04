@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mt-3">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item mr-2">
                                    <a href="{{ route('users.create') }}">Create User</a>
                                </li>

                                <li class="nav-item mr-2">
                                    <a href="{{ route('users.trashed') }}">Trashed Users</a>
                                </li>

                                <li class="nav-item mr-2">
                                    <a href="{{ route('posts.create') }}">Create Post</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
