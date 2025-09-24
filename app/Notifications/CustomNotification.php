<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class CustomNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $body,
        public ?array $data = null
    ){}

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        $client = app(\Kreait\Firebase\Contract\Messaging::class);

        return (new FcmMessage(
            notification: new FcmNotification(
                title: $this->title,
                body: $this->body
            ),
            data: $this->data ?: [],
            custom: [
                 'android' => [
                    'notification' => [
                        'color' => '#0A0A0A',
                    ],
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
                'apns' => [
                    'fcm_options' => [
                        'analytics_label' => 'analytics',
                    ],
                ],
            ]
        ))->usingClient($client);
    }

    
    /**
     * Get the array representation of the notification.
     */
     public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data,
        ];
    }
}