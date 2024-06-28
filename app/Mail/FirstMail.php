<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FirstMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // NOTE: Public properties are automatically make available to the email view
    public $user, $userEmail;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->userEmail = $user["email"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /* inside `build` method, where you're going to define which view to use, what the subject is, anything else you want to tweak about the mail except who it's going to */
        // return $this->markdown('emails.first-email', [
        //     'userName' => $this->user["name"],
        //     'userEmail' => $this->userEmail,
        // ]);

        /* mail templates are just like any other template. they can extend other templates, use sections, parse variables, contain conditionals or looping directives, and do anything else */

        // The `text` method to pass a plain-text version

        /* The `attach` attaches a file from a raw string this method has also another form to pass more options like file type and new name */

        /* The `attachData` attaches a file from a raw string this method has another form also to pass more options like attach method */

        // The `pirority` set the email's pirority, where 1 is the highest and 5 is the lowest

        /* The `withSwiftMessage` if you want to perform any manual modifications on the underlying swift message */
        /* NOTE: The `withSwiftMessage` method accepts a closure with a parameter to edit your email before sending it */

        /* The difference between `cc` and `bcc` that,
        When you CC people on an email, the CC list is visible to all other recipients. For example, if you CC bob@example.com and jake@example.com on an email, Bob and Jake will both know that the other received the email, as well */

        /* BCC stands for “blind carbon copy.” Unlike with CC, no one but the sender can see the list of BCC recipients. For example, if you have bob@example.com and jake@example.com in the BCC list, neither Bob nor Jake will know that the other received the email */

        return $this
            ->markdown('emails.first-email')
            ->subject('Laravel Digging')
            // ->text('emails.first-email')
            // ->attach(asset('user_1.png'))
            // ->attach(asset('user_1.png'), [
            //     'mime' => 'aplication/image',
            //     'as' => 'newName.png',
            // ])
            // ->attachData(asset('user_1.png'), 'asset_user_1')
            // ->attachData(file_get_contents(public_path('user_1.png')), 'asset_user_1', [
            //     'mime' => 'application/image',
            // ])
            // ->attachFromStorage(asset('user_1.png'), 'asset_user_1')
            // ->priority(2)
            // ->withSwiftMessage(function($swift) {
            //     $swift->setReplyTo('user@example.com');
            // })
            ->with([
                'userName' => $this->user["name"],
            ]);
    }
}
