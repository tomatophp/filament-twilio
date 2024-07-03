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
     * @return string
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public static function send(string $phone, string $message): string
    {
        $sid    = config('filament-twilio.twilio_sid');
        $token  = config('filament-twilio.twilio_token');
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create("whatsapp:" . $phone, // to
                array(
                    "from" => "whatsapp:". config('filament-twilio.twilio_sender'),
                    "body" => $message
                )
      );

      return $message->sid;
    }
}
