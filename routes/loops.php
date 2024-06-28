<?php

use Illuminate\Support\Facades\Route;

/* For more info: https://www.w3schools.com/php/keyword_yield.asp#:~:text=The%20yield%20keyword%20is%20used,the%20iterations%20of%20the%20loop. */

Route::get('generators', function () {

    function getNumbers()
    {
        dump('Before One');
        yield 'One';
        dump('After One');

        dump('Before Two');
        yield 'Two';
        dump('After Two');

        dump('Before Three');
        yield 'Three';
        dump('After Three');
    }

    $func = getNumbers();

    /* You can not access the returned value using `next` from the below line, because the returned value is a string So, you must do the next steps: as you say Hey! give me the first value then move the cursor to the next value and give me this value using `cuurent` */
    dump($func->current());

    $func->next();

    dump($func->current());
});

Route::get('foreach', function () {
    $oldUsers = ['user_1', 'user_2', 'user_3', 'user_4'];
    $newUsers = [];

    /* NOTE: If we didn't put `&` before the variable name then tries to print the value of a variable it will print null array and it unexpected But that's true according PHP. when we say `use ($newUsers)` PHP creates a new different variable called `newUsers` and when we push values to this array, it'll push the values to the new variable not the old one that we have. So, when you want to tell PHP hey PHP, please insert the values into the array that I have put `&` and this called passing by reference. */
    collect($oldUsers)->each(function ($user) use (&$newUsers) {
        array_push($newUsers, $user);
    });

    dd($newUsers);
});
