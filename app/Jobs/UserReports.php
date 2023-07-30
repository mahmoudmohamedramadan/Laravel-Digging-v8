<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};

class UserReports implements ShouldQueue
{
    /* `Dispatchable` gives its methods to dispatch itself; `Queueable` allows you to specify how Laravel should push this job to the queue; `InteractsWithQueue` allows each job, while being handled, to control its relationship with the queue including deleting or requeueing itself; and `SerializesModels` gives the job the ability to serialize and deserialize Eloquent models */

    /* There are multiple methods by which you can dispatch a job, including some methods available to every controller and a global `dispatch` helper. BUT since Laravel 5.5, we've had a simpler and preferred methods: caling the `dispacth` method on the job itself */

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->attempts() == 1) {
            return $this->user;
        }
    }

    public function failed()
    {
        // do something here that will be run when the queue is failed...
    }
}
