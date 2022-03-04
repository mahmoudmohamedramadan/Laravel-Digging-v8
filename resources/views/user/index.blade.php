@extends('layouts.app')

@section('title', 'Show Users')

{{-- The `@once` directive allows you to define a portion of the template that will only be evaluated once per rendering
cycle. For example, if you are rendering a given component within a loop, you may wish to only push the JavaScript to
the header the first time the component is rendered --}}
@once
@push('scripts')
<script>
    console.log('welcome from `user.index` view using push directive');
</script>
@endpush

@prepend('scripts')
{{-- code which written into `prepend` directive always be in the top of code which written into push directive (or
JavaScript code generally) --}}
<script>
    console.log('welcome from `user.index` view using prepend directive');
</script>
@endprepend
@endonce

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
        {{-- @foreach ($users as $user)
        <tr>
            <td><a href="{{ route('users.edit', $user->id) }}">{{ $user->id }}</a></td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                ## `include` is used to include a view and in case it NOT exists will trigger an issue, and you can pass
                data to view that will be included
                @include('includes.form_delete',['buttonText' => 'Delete'])

                ## `includeWhen` used to include a view in a specific condition
                @includeWhen(auth()->user()->email == 'admin@gmail.com','includes.form_delete')

                ## `includeIf` will include the file if exists and in case NOT exist will NOT trigger any issues
                @includeIf('includes.form_delete')

                ## `includeUnless` is the opposite of the `includeWhen`
                @includeUnless(auth()->user()->email =='admin@gmail.com','includes.form_delete')

                ## `includeFirst` directive take array of views as a first parameter and this directive take the first
                view you can pass data also
                @includeFirst(['includes.form_delete','test'],['buttonText' => 'Delete'])
            </td>
        </tr>
        @endforeach --}}

        {{-- `inject` directive allows you to take an instance from the second parameter(`class/interface`) in this
        example we will call `userController` as an object and call `getUsersForInjectDirective` method --}}
        {{-- @inject('userController', '\App\Http\Controllers\UserController')
        {{ $userController->getUsersForInjectDirective()->first() }} --}}

        {{-- `each` directive used to loop over users varibale in the `table_rows` view as user
        and in case of there is no users will call `none` view --}}
        @each('includes.table_rows', $users, 'user', 'includes.none')

        <div class="mb-3">
            {{-- the below line to specify that you want to work WITH `Bootstrap` instead of `TailwinCSS`, also the
            below line keeps you away from writing `Paginator::useBootstrap` in `AppServiceProvider` --}}
            {{-- {{ $users->links('pagination::bootstrap-4') }} --}}
            {{ $users->onEachSide(2)->links() }}
        </div>

        {{-- instead of manually calling `json_encode`, you may use the `@json` Blade directive --}}
        {{-- @json($users->toArray()) --}}

        {{-- In this example, the `@` symbol will be removed by Blade; however, {{ $users->first()->name }} expression
        will remain untouched by the Blade engine, and if you remove this symbol the name of the first user will be
        printed, NOTE that The `@` symbol may also be used to escape Blade directives: `@@json($users)` --}}
        {{-- @{{ $users->first()->name }} --}}

        {{-- If you are displaying JavaScript variables in a large portion of your template, you may wrap the HTML in
        the `@verbatim` directive so that you do not have to prefix each Blade echo statement with an `@` symbol --}}
        {{-- @verbatim
        <div class="container">
            Hello, {{ name }}.
        </div>
        @endverbatim --}}
    </tbody>
</table>

{{-- Instead of using `@json` you can use the next line a new Laravel version --}}
<script>
    console.log({{ Js::from(['a' => 1, 'b' => 2, 'c' => 3]) }});
</script>
@endsection
