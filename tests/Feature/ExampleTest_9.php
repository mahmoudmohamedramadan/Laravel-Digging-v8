<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\{Models\User, Mail\WelcomeNewUserMail};

class ExampleTest_9 extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mail_fakes()
    {
        /* The `Mail` facade offers four methods: `assertSent`, `assertNotSent`, `assertQueued`, `assertNotQueued`. Use the queued methods when your mail is queued and the `Sent` method when it's not

        Just like with `assertDispatched`, the first parameter will be the name of the mailable and the second parameter can be empty, the number of times the mailable has been sent, or a closure testing that the mailable has the right data in it */

        $user = User::find(1);

        Mail::fake();

        // Asserts a message was sent to a given email address
        Mail::assertSent(WelcomeNewUserMail::class, function ($mail) {
            return $mail->user;
        });

        // Asserts a message was sent to a given email addresses
        Mail::assertSent(WelcomeNewUserMail::class, function ($mail) use ($user) {
            /* All of messages checking for recipients [hasTo(), hasCc(), hasBcc()] can take eighter a single email address or an array or collection of addresses */
            return $mail->hasTo($user->name) &&
                $mail->hasCc($user->name) &&
                $mail->hasBcc($user->email);
        });

        // Asserts a message was sent twice
        Mail::assertSent(WelcomeNewUserMail::class, 2);

        // Asserts a message was not sent twice
        Mail::assertNotSent(WelcomeNewUserMail::class, 2);
    }
}
