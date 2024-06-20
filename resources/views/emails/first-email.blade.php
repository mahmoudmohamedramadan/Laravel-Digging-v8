@component('mail::message')
# Laravel Digging Project

### Mail Section

**Welcome {{ $userName }}**, we'd like to say that, we start a new topic in Laravel-Digging


if you'd to change this email **{{ $userEmail }}**, tell us before emabaring change

you can also take a look this project image

{{-- <img src="{{ asset('user_1.png') }}"> --}}

{{-- NOTE: This lower way does not work with markdown files --}}
{{-- <img src="{{ $message->embed(public_path('user_1.png')) }}"> --}}
{{-- <img src="{{ $message->embedData(public_path('user_1.png')) }}"> --}}


@component('mail::button', ['url' => 'https://github.com/mahmoudmohamedramadan/Laravel-Digging'])
GitHub
@endcomponent

Thanks,<br>
Mahmoud Mohamed Ramadan
@endcomponent
