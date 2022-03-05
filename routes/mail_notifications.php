<?php

use Illuminate\Support\Facades\Route;
use App\{Models\User, Mail\FirstMail};
use App\Http\Controllers\{MailController, NotificationsController};

Route::get('first_mail', [MailController::class, 'index']);

/* When you're developing emails in your applications, it's helpful to be able to preview how they'll render. you can rely on a tool like `Mailtrap` for this, and that is a useful tool, BUT it can also be helpful to render the mails directly in your browser and see your changes made immediately */

Route::get('preview_email', function () {
    return new FirstMail(User::first());
});

Route::get('mail_queue', [MailController::class, 'mailQueue']);
Route::get('sendNotification', [NotificationsController::class, 'index']);
