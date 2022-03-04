<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NotificationsGuide;
use Illuminate\Support\Facades\Notification;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = User::find(1);

        // $user->notify(new NotificationsGuide);

        /* you can also send using facades */
        // Notification::send($user, new NotificationsGuide);

        /* in some cases you want to send thounds of notification that may be slow down user exoerience, so probably want to queue your notifications. All notifications import the Queuable trait by default, so all you need to do is add implements `ShouldQueue` to your notification and Laravel will instantly move it to a queue */
        $delayUntil = now()->addMinutes(3);
        $user->notify((new NotificationsGuide)->delay($delayUntil));

        /* This email is automatically sent to the email property on the notifiable, but you can customize this behavior by adding a method to your notifiable class named `routeNotificationForMail` that returns the email address you'd like email notifications sent to

        if you want to modify the templates, publish them and edit to your views
        ***php artisan vendor:publish --tag=laravel-notifications*** */

        return 'done...';
    }
}
