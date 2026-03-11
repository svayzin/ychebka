<?php
return [
    'driver' => env('SMS_DRIVER', 'log'), // log, smsc, twilio и т.д.
    
    'smsc' => [
        'login' => env('SMSC_LOGIN'),
        'password' => env('SMSC_PASSWORD'),
        'sender' => env('SMSC_SENDER', 'Restaurant'),
    ],
    
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],
];