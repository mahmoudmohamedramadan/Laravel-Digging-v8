<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\{Models\User, Mail\GettingStarted};

class MailController extends Controller
{
    /* There are two different syntaxes in Laravel for sending mail: `classic` and `mailable`. NOTE that the `mailable` syntax is the preferred */

    public function index()
    {
        /* `send` method accepts three params, the first param is the name of mail view, the second one is an array of data, and the third is a closure in which you define how and where to send the email: from, to, CC, BC, subject and any meta data */
        // Mail::send('emails.first-email', ['user' => 'Mahmoud Mohamed Ramadan'], function ($mail) {
        //     $mail->from('laravel_diggind@laravel.com', 'Laravel Diggind');
        //     $mail->to('user@gmail.com', 'Mahmoud Ramadan')->subject('welcome man!');
        // });

        $user = User::findOrFail(1);

        Mail::to($user)->send(new GettingStarted($user));

        // You can write syntax like so:
        // Mail::to($user)
        //     ->cc(User::find(2))
        //     ->bcc(User::find(1))
        //     ->send(new GettingStarted($user));

        return 'done...';
    }
}
