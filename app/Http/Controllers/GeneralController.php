<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class GeneralController extends Controller
{
    /**
     * Use the stringable methods.
     *
     * @return string|array
     */
    public function helper()
    {
        $string = 'Welcome Laravel, I"am happy to learn you';

        // The `startsWith` check if haystack start with letter or word with the same case
        Str::startsWith($string, 'Welcome') ? 'true' : 'false';

        // The `endsWith` check if haystack end with letter or word with the same case
        Str::endsWith($string, 'you') ? 'true' : 'false';

        // The `contains` check if haystack contains letter or word with the same case
        Str::contains($string, 'L') ? 'true' : 'false';

        // The `is` check if haystack is the oher string
        Str::is($string, 'Welcome Laravel, I"am happy to learn you') ? 'true' : 'false';

        // The `slug` seperate every word with a hyphen or dash
        Str::slug('Welcome Laravel, I"am happy to learn you');

        // The `pulral` make a word in a plural form
        Str::plural('Cat');

        // The `singular` make a word in a singular form
        Str::singular('Cat');

        // The `camel` make a word in a camel form
        Str::camel('Welcome Laravel');

        // The `kebab` make a word in a kebab form
        Str::kebab('Welcome Laravel');

        // The `snake` make a word in a snake form
        Str::snake('Welcome Laravel');

        /* The `studly` make a word in a studly form (make all first letter in capital case without spaces between every word) */
        Str::studly('Welcome Laravel');

        /* The `title` make a word in a title form (make all first letter in capital case with spaces between every word) */
        Str::title('Welcome Laravel');

        // `after` remove a specific string and return what after removed string
        Str::after($string, 'Welcome Laravel,');

        // The `before` remove a specific string and return what before removed string
        Str::before($string, ', I"am happy to learn you');

        // The `limit` limits the given string
        Str::limit('Welcome Laravel', 5);

        /* The below line every comma in the string will be replaced with nothing then the `title` case will be appied */
        Str::of($string)->replace(',', '')->title();

        // The upper line equals to the lower line
        Str::of($string)->headline();

        /* The `mask` method is used to mask the passed text where the first param is the text that we want to mask, the second is the char that we will use to mask, the third is the number of chars that we will skip, and the fourth is the number of chars that we will mask */
        Str::mask($string, '*', 5, 6);

        /* In the new Laravel version, you can pass the count in the second param, and the function will determine if the first param will be `plural` Or `singular` */
        Str::plural('user', \App\Models\User::take(1)->get());

        // The `revese` revese the given text
        Str::revese('user');

        /* The `substrReplace` method will search for `,` between 0 and 5, if this char does not exist, it will be appended after the first 5 chars but if it exists then all the text before this char will be removed */
        return Str::substrReplace($string, ',', 0, 5);
    }

    /**
     * Use the localization feature.
     *
     * @return string
     */
    public function localization()
    {
        app()->setlocale('ar');

        // return __('validation.email', ['attribute' => 'البريد الالكتروني']);
        // return trans('validation.email', ['attribute' => 'البريد الالكتروني']);

        return trans_choice('validation.pluralOrSinglar', 5);
    }
}
