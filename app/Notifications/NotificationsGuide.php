<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificationsGuide extends Notification implements ShouldQueue
{
    /* To begin with, we're going to pass the relevant data to the constructor. In addition, there is a `via` method that allows us to define which notification channels should be used [$notifiable represents whatever entities you want to notify in your system], NOTE: every model will extends from `Authenticatable` will represents a `notifiable` instance, NOTE also: `Notifiable` trait not allows you to deal with `$notifiable` but allows you to use some methods like `notify`, `markAsRead`,...etc. The thing that allows you to deal with `$notifiable` is to extends the `Authenticatable` parent class */

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Here you can return an array directly
        // return ['mail'];

        /* You can use the methods in you notifiable model, NOTE: this method exists in a `User` model */
        return $notifiable->notifiableMethods();

        // You can use `pascal` case Or `snake` case
        return $notifiable->notifiable_methods;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /* You can change the style of the default template to be an `error` message, which uses a bit of different language and change the primary button to red just add a call to the `error` */
        return (new MailMessage)
            ->markdown('vendor.notifications.email', ['user' => $notifiable->name])
            ->error();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
