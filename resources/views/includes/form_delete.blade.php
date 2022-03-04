@php
$buttonWarningClass = 'btn btn-warning';
$buttonDangerClass = 'btn btn-danger';
@endphp

<button @class([$buttonWarningClass]) onclick="location.href='{{ route('users.edit', $user->id) }}'">
    {{ $buttonWarningText }}
</button>
<form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="DELETE">

    {{-- The `@class` directive conditionally compiles a CSS class string --}}
    <button @class([$buttonDangerClass])>{{ $buttonDangerText }}</button>
</form>
