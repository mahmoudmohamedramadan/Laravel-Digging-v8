<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\{Console\Command, Support\Facades\Artisan};

class ResetPassword extends Command
{
    /* `sendEmail` is an option BUT `userId` is an argument, NOTE that you should put [=] sign to say that option accepts a value, NOTE also that the string after `:` is a description for this option */
    protected $signature = 'reset:password {userId}{--sendEmail= : Notify the user that his password has been updated}';

    /* If you want to set a default value to the argument */
    // protected $signature = 'reset:password {userId}{--sendEmail=true}';

    /* If you want to say that a specific argument is an optional put `?` */
    // protected $signature = 'reset:password {userId?}{--sendEmail=true}';

    /* If you want to accept an array as argument put `*`, NOTE the difference between the next two lines, The first line accepts many `userId` like so `php artisan reset:password 1 2 3 4 5 ...`
    and The second one means that each id should assigend to `userId` argument like so `php artisan reset:password userId=1 userId=2 userId=3 userId=4 userId=5 ...` */
    // protected $signature = 'reset:password {userId*}';
    // protected $signature = 'reset:password {userId=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command for resetting user\'s password';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* To get all the passed arguments use `arguments` function */
        dd($this->arguments());

        /* To get all the passed options use `options` function */
        dd($this->options());

        User::findOrFail($this->argument('userId'))->update(['password' => null]);
        $this->info('password reseted successfully');
        if ($this->hasOption('sendEmail') and $this->option('sendEmail') == true) {
            // Artisan::call('mail:newuser ' . $this->argument('userId'));

            /* If you found the previous way in passing argument is a complex try the NEXT one */
            // Artisan::call('mail:newuser', [
            //     'userId' => $this->argument('userId')
            // ]);

            /* `callSilent` this method allows you to call a command BUT without output */
            $this->callSilent('mail:newuser', [
                'userId' => $this->argument('userId')
            ]);

            $this->comment('mail sent successfully');
        }
    }
}
