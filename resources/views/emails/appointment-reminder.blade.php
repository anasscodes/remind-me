<h2>Reminder ⏰</h2>

<p>Hello {{ $appointment->user->name }},</p>

<p>You have an appointment:</p>

<ul>
    <li><strong>Title:</strong> {{ $appointment->title }}</li>
    <li><strong>Date:</strong> {{ $appointment->appointment_at->format('d M Y H:i') }}</li>
</ul>

<p>Don't forget 😊</p>
