<?php

use App\{Models\User, Mail\WelcomeNewUserMail};
use Illuminate\{Support\Str, Foundation\Inspiring, Support\Facades\Mail, Support\Facades\Artisan};

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/* if you found that command class is complex you can deal with the simpler type of command via writing commands here
    NOTE that if you've command class contains `bla:bla` command and you tried to write this command again here it will be overridden because this file is called after the commands classes according to `command` method in the `\App\Console\Kernel.php`, NOTE also that changes in arguments and options NOT consider as override BUT if you want to make override change the command itself */
Artisan::command('mail:newuser {userId}', function ($userId) {
    $userId = $this->argument('userId');

    Mail::to(User::findOrFail($userId))->send(new WelcomeNewUserMail(User::find($userId)->name));

    if (!Mail::failures()) {
        return $this->info('email sent successfully');
    }

    return $this->warn('User not found Or email does not sent successfully!');
})->purpose('Write command as a colsures instead of class');

Artisan::command('make:post {--expanded}', function () {
    $title = $this->ask('what is the post title?');

    $this->comment('creating at ' . Str::slug($title) . 'md');

    $this->choice('whats category', ['technology', 'constructive'], 0);

    // Create a post here

    $this->comment('post created');
});
