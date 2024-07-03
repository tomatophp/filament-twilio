<?php

namespace TomatoPHP\FilamentTwilio\Services;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

/**
 *
 * @method Twilio static string send(string $phone, string $message)
 */
class Twilio
{
    /**
     * @param string $phone
     * @param string $message
     * @param ?string $mediaURL
     * @return string
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public static function send(string $phone, string $message, ?string $mediaURL = null): string
    {
        $sid    = config('filament-twilio.twilio_sid');
        $token  = config('filament-twilio.twilio_token');
        $twilio = new Client($sid, $token);

        $body = [];

        if($mediaURL){
            $body["mediaUrl"] = $mediaURL;
        }

        $body["from"] = "whatsapp:". config('filament-twilio.twilio_sender');
        $body["body"] = $message;

        $message = $twilio->messages->create("whatsapp:" . $phone,$body);
        return $message->sid;
    }
}
