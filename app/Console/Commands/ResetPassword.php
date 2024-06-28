<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use Illuminate\{Console\Command, Support\Facades\Artisan};

class ResetPassword extends Command
{
    // The `sendEmail` is an option but `userId` is an argument
    /* NOTE: You should put the [=] sign to say that the option accepts a value, also the string after the `:` is a description for this argument or option */
    protected $signature = 'password:reset {password : The new password}{--sendEmail= : Notify the user that his password has been updated}';

    // If you want to set a default value to the argument
    // protected $signature = 'password:reset {userId}{--sendEmail=true}';

    // If you want to say that a specific argument is an optional put `?`
    // protected $signature = 'password:reset {userId?}{--sendEmail=true}';

    // If you want to accept an array as argument put `*`
    /* NOTE: The difference between the next two lines, The first line accepts many `userId` like so `php artisan password:reset 1 2 3 4 5 ...`
    and The second one means that each id should assigend to `userId` argument like so `php artisan password:reset userId=1 userId=2 userId=3 userId=4 userId=5 ...` */
    // protected $signature = 'password:reset {userId*}';
    // protected $signature = 'password:reset {userId=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the user password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // To get all the passed arguments use the `arguments` method
        dd($this->arguments());

        // To get all the passed options use the `options` method
        dd($this->options());

        auth()->user()?->update(['password' => Hash::make($this->argument('password'))]);

        $this->info('password was reseted successfully!');

        if ($this->hasOption('sendEmail') && $this->option('sendEmail') == true) {
            // Artisan::call('mail:newuser ' . $this->argument('userId'));

            // If you found the previous way in passing argument is a complex, try the next one
            // Artisan::call('mail:newuser', [
            //     'userId' => $this->argument('userId')
            // ]);

            // The `callSilent` method allows you to call a command but without output
            $this->callSilent('mail:newuser', [
                'userId' => $this->argument('userId')
            ]);

            $this->comment('mail sent successfully');
        }
    }
}
