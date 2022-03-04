<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\{Models\User, Notifications\TestNotification};

class ExampleTest_10 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_notifications_fake()
    {
        /* `Notification` facade offers two methods: `assertSentTo`, `assertNothingSent`
        Unlike with the Mail facade, you're NOT going to test who the notification was sent to manually in a closure.
        The first parameter be either a single notifiable `object` or an `array` or `collection` of them, the second parameter is the class name for the notificaion, and the [optional] third parameter can be a closure defining more expectations about the notifications */

        $user = User::find(1);
        $users = User::get();

        Notification::fake();

        /* Assert author was notified */
        Notification::assertSentTo($user, new TestNotification(auth()->user()), function ($notification) use ($user) {
            return $notification->user->id == $user->id;
        });

        /* Assert a notification was sent to the given users */
        Notification::assertSentTo($users, new TestNotification(auth()->user()));

        /* Assert a notification was NOT sent */
        Notification::assertNotSentTo($user, new TestNotification(auth()->user()));
    }
}
