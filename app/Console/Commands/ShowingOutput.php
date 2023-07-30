<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowingOutput extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'output:show';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the output to the user';

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
        // Here will return all users with `name` and `email` columns
        $users = User::all(['name', 'email'])->toArray();

        // `table` method produced data/result in a table
        $this->table(['name', 'email'], $users);

        /* If you want to see the command-line progress bar do this...
         `progressSart` to begin or prepare your command-line to the progress bar and `progressAdvance` to add the value to the bar, you can pass the value that you want to sum to the bar value and `progressFinish` to finish your work, NOTE that: the `progressStart` method accepts the maximum of progress bar */
        $this->output->progressStart(count($users));
        for ($i = 0; $i < count($users); $i++) {
            sleep(1);
            dump($users[$i]['name'] . ', ' . $users[$i]['email']);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }
}
