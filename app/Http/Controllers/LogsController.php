<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class LogsController extends Controller
{
    /* The purpose of logs is to increase "discoverability", or your ability to understand what's going on at any given moment in your application. without any modifications, your app will write any log statements to a file located at `storage/logs/laravel.log` */

    /* The most common use case for logs is to act as a semi-disposable record of things that have happend that you may care about later, but to which you do not definitively need programmatic access, The logs are more about learning what's going on in the app and less about creating structured data your app can consume */

    public function writingLogs()
    {
        Log::emergency('$message');
        Log::alert('$message');
        Log::critical('$message');
        Log::error('$message');
        Log::warning('$message');
        Log::notice('$message');
        Log::info('$message');
        Log::debug('$message');

        // You can optionally pass a second parameter that's an array of context data
        Log::error('$message', ['user' => User::find(1)]);

        /* Like many other aspects of Laravel [file storage, database, email, etc] you can configure your logs to use one ot more predefined log types, which you define in the config file */

        /* The single channel writes every log entry to a single file, which you'll define in the path key. you can see its default configuration in `config/logging.php` */

        // The daily channel splits out a new file for each day. you can see its default config
    }
}
