<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TuffnellNotification extends Notification
{
    use Queueable;

    protected $tuffnelFile;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tuffnelfile)
    {
        $this->tuffnelFile = $tuffnelfile;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->email = $notifiable->slug;
        return (new MailMessage)->attach(public_path("storage/tuffnell/" . $this->tuffnelFile), [
            'mime' => 'application/txt',
        ])
            ->subject('Tuffnell File')
            ->greeting('Hello')
            ->line("Tuffnell txt file is ready to send.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
