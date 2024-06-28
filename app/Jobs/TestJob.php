<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{SerializesModels, InteractsWithQueue};
use Illuminate\Contracts\Queue\{ShouldQueue, ShouldBeUnique};

class TestJob implements ShouldQueue
{
    /* `SerializesModels` trait always serialize the data then deserialize it At the first, `__serialize` method will be called then `getSerializedPropertyValue` method will be triggered with the same count of properties which are `11` and finally Laravel automatically restore the entire model from the database so it's preferred to pass the model to this Job constructor because imagine that the user enters an invalid email so Laravel will not restore the entire model instance but if you pass the model instance and user pass invalid email then realizes that, he will pass correct one So, Laravel will retrieve the correct instance */
    // For more info: https://gistlog.co/JacobBennett/e60d6a932db98985f160146b09455988
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(private $user)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::all()->chunk(10)->each(function ($users) {
            // NOTE: The `$users` carries 10 users over each iteration
        });
    }
}
