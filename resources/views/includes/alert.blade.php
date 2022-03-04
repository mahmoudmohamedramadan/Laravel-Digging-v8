@if (Session::has('success'))
<div class="row flex justify-center mr-2 ml-2">
    <div class="col-md-6">
        <button class="btn btn-lg btn-block btn-outline-success mb-2">
            {{ Session::get('success') }}
        </button>
    </div>
</div>
@elseif(Session::has('error'))
<div class="row flex justify-center mr-2 ml-2">
    <div class="col-md-6">
        <button class="btn btn-lg btn-block btn-outline-danger mb-2">
            {{ Session::get('error') }}
        </button>
    </div>
</div>
@endif
