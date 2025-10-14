<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification; 

class PushNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $body;
    protected array $dataPayLoad;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $title, string $body, array $dataPayLoad = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->dataPayLoad = $dataPayLoad;
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
        $defaultData = [
            'type' => 'general_message',
            'user_id' => (string)($notifiable->id ?? 'n/a') 
        ];
        $mergedData = array_merge($defaultData, $this->dataPayLoad);

        return (new FcmMessage(
            notification: new FcmNotification(
            title: $this->title,
            body: $this->body
        )
        ))
         ->data($mergedData)
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
