@extends('layouts.app')

@section('title', 'Book View')

@section('content')

<div class="flex justify-content-centter">
    <div class="col-md-6">
        <ul>
            @foreach ($lettersArray as $letter)
            {{-- loop variable is a variable available in loops like(foreach, forelse) --}}

            {{-- `index` return the index of the letter --}}
            <li>index: {{ $loop->index }}</li>

            {{-- `iteration` return the iteration number of the loop --}}
            <li>iteration: {{ $loop->iteration }}</li>

            {{-- `remaining` return how many iteration remaining --}}
            <li>remaining: {{ $loop->remaining }}</li>

            {{-- `count` returns the count of the `lettersArray` --}}
            <li>count: {{ $loop->count }}</li>

            {{-- when loop be in the first item will print first: 1 and last: null --}}
            <li>first: {{ $loop->first }}</li>

            {{-- when loop be in the last item will print last: 1 and first: null --}}
            <li>last: {{ $loop->last }}</li>

            {{-- when loop be in the odd item will print odd: 1 and even: null --}}
            <li>odd: {{ $loop->odd }}</li>

            {{-- when loop be in the even item will print even: 1 and odd: null --}}
            <li>even: {{ $loop->even }}</li>

            {{-- count of nested loop if you have two nested for will print 2 --}}
            <li>depth: {{ $loop->depth }}</li>

            {{-- `parent` will point to parent foreach in case you have two nested foreach, NOTE in case nested loop you
            will print the object of the outer/first loop so, you can access all upper keys from `parent` like
            $loop->parent->index --}}
            <li>parent: {{ $loop->parent }}</li>
            <li>---------------------</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="flex justify-content-center">
    <div class="col-md-6">
        <a href="{{ URL::route('posts.index') }}">URL Route</a>
    </div>
</div>
<div class="flex justify-content-center">
    <div class="col-md-6">
        <a href="{{ URL::signedRoute('posts.index') }}">URL Signed Route</a>
    </div>
</div>
<div class="flex justify-content-center">
    <div class="col-md-6">
        <a href="{{ URL::temporarySignedRoute('posts.index', now()->addMinutes(2)) }}">
            URL Temporary Signed Route
        </a>
    </div>
</div>

@stop

{{-- here without `parent` directive we will overwrite what inside parent section --}}
@section('parent')
<script>
    console.log('Children');
</script>
{{-- parent directive used to show script in parent section, NOTE where you call `parent` directive before or after
`section` directive body --}}
@parent
@endsection
