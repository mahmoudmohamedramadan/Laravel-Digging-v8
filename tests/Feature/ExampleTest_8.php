<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\TestJob;
use Illuminate\Support\Facades\{Bus, Queue};

class ExampleTest_8 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_job()
    {
        /* The `Bus` facade, which represents how Laravel dispatches jobs, works just like Event. You can run `fake` on it to disable the impact of your jobs, and after faking it you can run `assertDispatched` or `assertNotDispatched` */
        Bus::fake();

        Bus::assertDispatched(TestJob::class, function ($job) {
            return $job;
        });

        /* assert a job was NOT dispathced */
        Bus::assertNotDispatched(TestJob::class);
    }

    public function test_queue()
    {
        /* The Queue facade represent how Laravel dispatches jobs when they're pushed up to queues, Its available methods are `assertPushed`, `assertPushedOn` and `assertNotPushed` */
        Queue::fake();

        Queue::assertPushed(TestJob::class, function ($job) {
            return $job;
        });

        /* assert a job was pushed to a given queue named `queue-name` */
        Queue::assertPushedOn('queue-name', TestJob::class);

        /* assert a job was pushed twice */
        Queue::assertPushed(TestJob::class, 2);

        /* assert a job was NOT pushed */
        Queue::assertNotPushed(TestJob::class);
    }
}
