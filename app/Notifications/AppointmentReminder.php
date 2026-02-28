<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
{
    use Queueable;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database']; // نخزنو ف DB
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->appointment->title,
            'time' => $this->appointment->appointment_at->format('H:i'),
        ];
    }
}
