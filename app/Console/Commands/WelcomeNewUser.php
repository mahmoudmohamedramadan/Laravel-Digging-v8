<?php

namespace App\Console\Commands;

use App\{Models\User, Mail\WelcomeNewUserMail};
use Illuminate\{Console\Command, Support\Facades\Mail};

class WelcomeNewUser extends Command
{
    /* If you want to write a signature while writing the command artisan write `--command=your_signature` */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:newuser {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command for welcome every new user via email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /* When you run signature the handle method will triggered */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // User::get()->each(function ($user) {
        //     Mail::to($user)->send(new WelcomeNewUserMail);
        // });

        // Mail::send('view_file', ['your_data'], function ($message) {
        //     $message->to('')->subject('');
        //     $message->from('');
        // });

        $userId = $this->argument('userId');

        Mail::to(User::findOrFail($userId))->send(new WelcomeNewUserMail(User::find($userId)->name));

        if (!Mail::failures()) {
            return $this->info('email sent successfully');
        }

        return $this->warn('An error happens while sending the email');
    }
}
