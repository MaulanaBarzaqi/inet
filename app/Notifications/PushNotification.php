<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification; 

class PushNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $body;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
    //    return new FcmMessage(
    //     notification:  new FcmNotification(
    //         title: $this->title,
    //         body: $this->body
    //         )
    //     );
        return (new FcmMessage(
            notification: new FcmNotification(
            title: $this->title,
            body: $this->body
        )
        ))
         ->data([
         'type' => 'general_message',
          'user_id' => (string)($notifiable->id ?? 'n/a') 
        //  'user_id' => $notifiable->id ?? 'n/a'
         ])
         ->custom([
             'android' => [
                 'notification' => [
                     'color' => '#5cb85c'
                 ]
             ]
         ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
