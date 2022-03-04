@component('mail::message')
# Hi {{ $user }}, Welcome From Laravel App

Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quos ipsa voluptate earum illo odio ut voluptatibus temporibus quia reprehenderit, aut, iure dolorem rem nulla totam voluptatem placeat rerum. At, sed.

@component('mail::button', ['url' => 'https://github.com/mahmoudmohamedramadan/bookStudy'])
Github
@endcomponent

Thanks,<br>
Mahmoud Mohamed Ramadan
@endcomponent
