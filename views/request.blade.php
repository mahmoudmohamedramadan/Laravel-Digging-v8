@extends('layouts.app')

@section('title', 'Request Page')

@push('scripts')

<script>
    $(document).ready(() => {
            $('#post-form').on('submit', (e) => {
                e.preventDefault();
                var formData = new FormData($('#post_form')[0]);
                $.ajax({
                    type: 'post',
                    url: "{{ url('requestPost') }}",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    success: function(data) {
                        if (data.success) {
                            $('#messageAlertPost').attr('class', 'btn btn-lg btn-block btn-outline-success');
                        }
                        else {
                            $('#messageAlertPost').attr('class', 'btn btn-lg btn-block btn-outline-danger');
                            $('.alert-post').prop('hidden', false);
                            $('#messageAlertPost').text(data.msg);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });
</script>

@endpush

@section('content')

<form action="{{ url('requestPost') }}" method="POST" id="post_form">
    @csrf

    <div class="justify-center alert-post" hidden>
        <div class="col-md-6">
            <div class="form-group">
                <button id="messageAlertPost" class=""></button>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <div class="col-md-6 form-group">
            <label>First Name</label>
            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
            @error('first_name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-center">
        <div class="col-md-6 form-group">
            <label>Last Name</label>
            <input type="text" class="form-control" name="last_name">
            <span class="text-danger">{{ $errors->first('last_name') }}</span>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Submit (POST)</button>
        </div>
    </div>
</form>

<br>
<hr>

<div class="mt-3">
    <form action="{{ route('requestGET', ['first' => 'Mahmoud', 'last' => 'Osama']) }}" method="GET">

        <div class="flex justify-center">
            <div class="col-md-6">
                <div class="form-group">
                    <h2 class="text-gray-500 text-xl">RequestGET</h2>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Submit (GET)</button>
            </div>
        </div>
    </form>
</div>

<br>
<hr>

<div class="mt-3">
    <form action="{{ url('requestPostFile') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex justify-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label>File</label>
                    <input type="file" class="form-control" name="file">
                    @error('file')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Submit (File)</button>
            </div>
        </div>
    </form>
</div>

<br>
<hr>

<div class="mt-3">
    <form action="{{ url('requestMethods') }}" method="POST">
        @csrf

        <div class="flex justify-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Submit (userRequest&State)</button>
            </div>
        </div>
    </form>
</div>

<br>
<hr>

<div class="mt-3">
    <form action="{{ url('persistenceRequest') }}" method="POST">
        @csrf

        <div class="flex justify-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                    @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="last_name">
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Submit (persistence)</button>
            </div>
        </div>
    </form>
</div>
@endsection
