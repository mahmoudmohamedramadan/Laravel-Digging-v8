<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificationsGuide extends Notification implements ShouldQueue
{
    /* First, wr're going to pass relevant data into the constructor. Second, there's `via` method that allows us to define, for a given user, which notification channels to use ($notifiable represents whatever entities you want to notify in your syste) NOTE that every model will extends from `Authenticatable` will represents a `notifiable` instance also, NOTE that `Notifiable` trait that which NOT allow you to deal WITH `$notifiable` BUT is allow you to use some methods like `notify`, `markAsRead`,...etc. The thing that allows you to deal WITH `$notifiable` is to extends the `Authenticatable` parent class */

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
        /* here you can return an array directly */
        // return ['mail'];

        /* or use the method in you notifiable model, NOTE that this method exists in a `User` model */
        return $notifiable->notifiableMethods();

        /* you can use `pascal` case Or `snake` case */
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
        /* you can also change the style of the default template to be an `error` message, which uses a bit of different language and change the primary button to red just add a call to the `error` */
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
