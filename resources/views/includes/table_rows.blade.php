<tr>
    <td><a href="{{ route('users.edit', $user->id) }}">{{ $user->id }}</a></td>
    <td>{{ $user->name }}</td>
    {{-- The lower line is a new syntax and means if the `$user` exists Or has a value then give me the `$email` of that user --}}
    <td>{{ $user?->email }}</td>
    <td>
        @include('includes.form_delete',['buttonWarningText' => 'Edit', 'buttonDangerText' => 'Delete'])
    </td>
</tr>
