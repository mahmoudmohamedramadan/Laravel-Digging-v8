<?php

use Illuminate\Support\Facades\Route;

/* For more info read: https://www.w3schools.com/php/keyword_yield.asp#:~:text=The%20yield%20keyword%20is%20used,the%20iterations%20of%20the%20loop. */

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

    $func =  getNumbers();

    /* You can not access the returned value using `next` from the below line, because the returned value is a string So, you must do the next steps: as you say Hey! give me the first value then move the cursor to the next value and give me this value using `cuurent` */
    dump($func->current());

    $func->next();

    dump($func->current());
});
