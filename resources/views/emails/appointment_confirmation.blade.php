<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #007BFF; margin-top: 0;">{{ $subject }}</h2>

        @if(!empty($content))
        <div style="line-height: 1.6; margin-bottom: 20px; padding: 10px; background-color: #f0f8ff; border-radius: 5px;">
            <strong>Message:</strong><br>
            {!! nl2br(e($content)) !!}
        </div>
        @endif

        <hr style="margin: 30px 0;">

        <h3 style="margin-bottom: 10px;">Appointment Details</h3>
        <ul style="list-style: none; padding-left: 0;">
            <li><strong>Date:</strong> {{ $appointment->appointment_date }}</li>
            <li><strong>Student ID:</strong> {{ $appointment->studentid }}</li>
            <li><strong>Course:</strong> {{ $appointment->doctor }}</li>
        </ul>

        <p style="margin-top: 30px;">Thank you,<br>For your waiting</p>
    </div>
</body>
</html>