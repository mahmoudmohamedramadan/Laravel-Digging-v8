@extends('layouts.app')

@section('title', 'Storage & Retrieval | Laravel Digging')

@section('content')

<div class="flex justify-content-center">
    <div class="col-md-8">
        <form action="{{ url('storagePutUploadedFiles') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="img">
                    <label class="custom-file-label">Choose file</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mt-5 flex justify-content-center">
    <div class="col-md-8">
        <form action="{{ url('storageUpdatePicture') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="img">
                    <label class="custom-file-label">Choose file</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
