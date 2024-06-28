<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use App\Events\SayWelcomeToNewUserEvent;

class ExampleTest_7 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_event_fake()
    {
        /* Suppose your app pushes notifications to `https://slack.com/intl/en-eg/` every time a new user signs up. You have a `user singed up` event that's dispatched when this happens, and it has a listener that noifies a `Slack` channel that a user has signed up. You do not want those notifications to go to Slack every time you run your tests, but you might want to assert that the event was sent, or listener was triggered, or something else
        This is one reason for faking certain aspects of Laravel in our test */
        Event::fake();

        /* Once we've run the `fake` method, we can also call special assertions on the Event facade: `assertDispatched` and `assertNotdispatched`, NOTE: the [optional] closure we're passing to `assertDispatched` makes it so we're noy just asserting that the even was dispatched, but also that dispatched event contains certain data, NOTE: `fake` method aslo disable eloquent model events. So if you have any important code, for example, in a model's creating event, make sure to create your models before `Event::fake()` */
        Event::assertDispatched(new SayWelcomeToNewUserEvent(auth()->id), function($event) {
            return $event->userId == 1;
        });

        // Signs multiple users up and asserts it was dispatched twice
        Event::assertDispatched(SayWelcomeToNewUserEvent::class, 2);

        // Signs up with validation failures and assert it was not dispatched
        Event::assertNotDispatched(SayWelcomeToNewUserEvent::class);
    }
}
