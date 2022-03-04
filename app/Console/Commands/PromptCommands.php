<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PromptCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prompt:me';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command for prompting the user actions';

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
        $name = $this->ask('What\'s your name ?', 'Your Name is Mahmoud Mohamed Ramadan');

        if (str_starts_with($name, 'Your')) {
            dump($name);
        }

        dump('Your Name is ' . $name);

        /* `secret` method does NOT show what you are typing */
        $password = $this->secret('Please Enter Password');

        if (!empty($password)) {
            if ($password == 'admin') {
                dump('Welcome Admin');
            } elseif ($password == 'user') {
                dump('Welcome User');
            } else {
                $this->error('Undefined Authentication!');
            }
        } else {
            $this->error('Please Enter Password');
        }

        $choice = $this->choice('Do you want exit from the system?', ['Yes', 'No'], 'Yes');

        if ($choice == 'Yes') {
            $confirm = $this->confirm('Do really want to exit');
            if ($confirm == 'yes') {
                dd('Command Finished');
            }

            /* `anticipate` allows the user to enter freeform from text and provides autocomplete suggestions */
            $this->anticipate(
                'So What do you want now?',
                ['Continue With System', 'I Was Launghing and i want to exit really', 'Nothing']
            );
            dd('Still Listening...');
        }

        dd('Still Listening...');
    }
}
