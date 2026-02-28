<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\AppointmentReminder;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentReminderMail;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
          $now = Carbon::now();

        $appointments = Appointment::where('is_done', false)
            ->where('reminded', false)
            ->get();

      foreach ($appointments as $appointment) {

    $remindTime = $appointment->appointment_at
        ->copy()
        ->subMinutes($appointment->remind_before);

    if ($now >= $remindTime) {

       // 🔔 database notification
    $appointment->user->notify(
        new AppointmentReminder($appointment)
    );

    // 📧 EMAIL reminder
    Mail::to($appointment->user->email)
        ->send(new AppointmentReminderMail($appointment));

    $appointment->update([
        'reminded' => true
    ]);
        
    }
}

    }
}
