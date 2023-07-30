<?php

namespace App\Console\Commands;

use Illuminate\{Console\Command, Support\Facades\Mail};
use App\{Models\User, Mail\WelcomeNewUser as WelcomeNewUserMail};

class WelcomeNewUser extends Command
{
    // If you want to write a signature while creating the command class pass the next option `--command=your_signature`

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new-user:welcome {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Greeting the new user with the given id via email';

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
        // User::get()->each(function ($user) {
        //     Mail::to($user)->send(new WelcomeNewUser);
        // });

        // Mail::send('view_file', ['your_data'], function ($message) {
        //     $message->to('')->subject('');
        //     $message->from('');
        // });

        $userId = $this->argument('userId');

        Mail::to(User::findOrFail($userId))
            ->send(new WelcomeNewUserMail(User::find($userId)->name));

        return $this->warn('An error happens while sending the email!');
    }
}
