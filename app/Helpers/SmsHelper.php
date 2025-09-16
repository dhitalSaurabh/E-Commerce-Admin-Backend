<?php

namespace App\Helpers;

use Twilio\Rest\Client;

class SmsHelper
{
    public static function sendSms($to, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_FROM');

        $client = new Client($sid, $token);
        $client->messages->create("+977" . $to, [
            'from' => $from,
            'body' => $message
        ]);
    }
}
