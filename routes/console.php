<?php

use App\{Models\User, Mail\WelcomeNewUser};
use Illuminate\{Support\Str, Foundation\Inspiring, Support\Facades\Mail, Support\Facades\Artisan};

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/* If you found the command class is complex, you can use a simpler type of a command by writing the commands here */
/* NOTE: If you have a Command class with a `bla:bla` signature and you tried to write this command again here it will be overridden because this file is called after the commands classes after have been loaded, according to the `commands` method in the `\App\Console\Kernel.php` */
/* NOTE: The changes in the arguments and options not considered overriding and if you want to make override, you can change the action itself */
Artisan::command('new-user:welcome {userId}', function ($userId) {
    $userId = $this->argument('userId');

    Mail::to(User::findOrFail($userId))->send(new WelcomeNewUser(User::find($userId)->name));

    return $this->warn('User not found Or email does not sent successfully!');
})->purpose('Write command as a colsures instead of class');

Artisan::command('make:post {--expanded}', function () {
    $title = $this->ask('what is the post title?');

    $this->comment('creating at ' . Str::slug($title) . 'md');

    $this->choice('whats category', ['technology', 'constructive'], 0);

    // Create a post here...

    $this->comment('post created');
});
