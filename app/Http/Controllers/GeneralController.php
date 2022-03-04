<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class GeneralController extends Controller
{
    public function helper()
    {
        $string = 'Welcome Laravel, I"am happy to learn you';

        /* `startsWith` check if haystack start with letter or word with the same case */
        Str::startsWith($string, 'Welcome') ? 'true' : 'false';

        /* `endsWith` check if haystack end with letter or word with the same case */
        Str::endsWith($string, 'you') ? 'true' : 'false';

        /* `contains` check if haystack contains letter or word with the same case */
        Str::contains($string, 'L') ? 'true' : 'false';

        /* `is` check if haystack is the oher string */
        Str::is($string, 'Welcome Laravel, I"am happy to learn you') ? 'true' : 'false';

        /* `slug` seperate every word with a hyphen or dash */
        Str::slug('Welcome Laravel, I"am happy to learn you');

        /* `pulral` make a word in a plural form */
        Str::plural('Cat');

        /* `singular` make a word in a singular form */
        Str::singular('Cat');

        /* `camel` make a word in a camel form */
        Str::camel('Welcome Laravel');

        /* `kebab` make a word in a kebab form */
        Str::kebab('Welcome Laravel');

        /* `snake` make a word in a snake form */
        Str::snake('Welcome Laravel');

        /* `studly` make a word in a studly form(make all first letter in capital case without spaces between every word) */
        Str::studly('Welcome Laravel');

        /* `title` make a word in a title form(make all first letter in capital case with spaces between every word) */
        Str::title('Welcome Laravel');

        /* `after` remove a specific string and return what after removed string */
        Str::after($string, 'Welcome Laravel,');

        /* `before` remove a specific string and return what before removed string */
        Str::before($string, ', I"am happy to learn you');

        /* `limit` a specific words in string */
        Str::limit('Welcome Laravel', 5);

        /* in the below line every comma in the string will be replaced WITH nothing then the `title` case will be appied */
        Str::of($string)->replace(',', '')->title();

        /* the upper line equals to the lower line */
        Str::of($string)->headline();

        /* `mask` method used to mask the passed text where, the first param is the text that we want to mask, the second is the char that we will use to mask our text, the third the number of chars that we will skip, and the fourth is the number of chars that we will mask */
        Str::mask($string, '*', 5, 6);

        /* in a new Laravel version, you can pass the count in the second param, and the function will determine if the first param will be `plural` Or `singular` */
        Str::plural('user', \App\Models\User::take(1)->get());

        /* `revese` revese the given text */
        Str::revese('user');

        /* `substrReplace` method will search for `,` BETWEEN 0 and 5 if NOT exists the `,` will be appended after first 5 chars BUT if was exist then all text before `,` will be removed */
        return Str::substrReplace($string, ',', 0, 5);
    }

    public function localization()
    {
        app()->setlocale('ar');

        // return __('validation.email', ['attribute' => 'البريد الالكتروني']);
        // return trans('validation.email', ['attribute' => 'البريد الالكتروني']);

        return trans_choice('validation.pluralOrSinglar', 5);
    }
}
