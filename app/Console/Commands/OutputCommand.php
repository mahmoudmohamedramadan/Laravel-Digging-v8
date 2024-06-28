<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class OutputCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'output:result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command for showing the output to the user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // The below line will return all users with two columns only which are `name` and `email`
        $users = User::all(['name', 'email'])->toArray();

        // The `table` method produced the data in a table
        $this->table(['name', 'email'], $users);

        /* If you want to see the command-line progress bar do this...
         `progressSart` to begin or prepare your command line to the progress bar and `progressAdvance` to add the value to the bar, you can pass the value that you want to sum to the bar value and `progressFinish` to finish your work */
        // NOTE: The `progressStart` method accepts the maximum of progress bar
        $this->output->progressStart(count($users));
        for ($i = 0; $i < count($users); $i++) {
            sleep(1);
            dump($users[$i]['name'] . ', ' . $users[$i]['email']);
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }
}
