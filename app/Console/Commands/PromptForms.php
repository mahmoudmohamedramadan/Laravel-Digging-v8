<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PromptForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forms:prompt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prompt user action forms';

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
        $name = $this->ask('What\'s your name ?', 'Mahmoud Mohamed Ramadan');

        dump('Your Name is ' . $name);

        // `secret` method does not show what you are typing
        $password = $this->secret('Please Enter Your Password');

        if (empty($password)) {
            $this->error('Undefined Authentication!');
        }

        $choice = $this->choice('Do you want exit from the system?', ['Yes', 'No'], 'Yes');

        if ($choice == 'Yes') {
            $confirm = $this->confirm('Do really want to exit!');

            if ($confirm == 'yes') {
                dd('Thanks For Your Time!');
            }

            // `anticipate` allows the user to enter freeform from text and provides autocomplete suggestions
            $this->anticipate(
                'So What do you want now?',
                ['Continue With System', 'I Was Launghing and I want to exit really', 'Nothing']
            );
        }
    }
}
