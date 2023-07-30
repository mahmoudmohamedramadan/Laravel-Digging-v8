<?php

namespace App\Macros;

class StrMacroable
{
    /* We'll not need to accept the `$str` param in the function we just take whole the closure of the second param from the `macro` method */
    public function customSplitOne()
    {
        return function ($str) {
            return 'ABC-One-' . substr($str, 0, 3) . '-' . substr($str, 3);
        };
    }
}
