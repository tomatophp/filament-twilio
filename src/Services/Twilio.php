<?php

namespace TomatoPHP\FilamentTwilio\Services;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Twilio
{
    /**
     * Whether the Twilio SID, token and WhatsApp sender are configured.
     */
    public static function isConfigured(): bool
    {
        return filled(config('filament-twilio.twilio_sid'))
            && filled(config('filament-twilio.twilio_token'))
            && filled(config('filament-twilio.twilio_sender'));
    }

    /**
     * Send a WhatsApp message and return the Twilio message SID.
     *
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public static function send(string $phone, string $message, ?string $mediaURL = null): string
    {
        /** @var Client $twilio */
        $twilio = app(Client::class);

        $body = [];

        if ($mediaURL) {
            $body['mediaUrl'] = [$mediaURL];
        }

        $body['from'] = static::whatsapp((string) config('filament-twilio.twilio_sender'));
        $body['body'] = $message;

        return $twilio->messages->create(static::whatsapp($phone), $body)->sid;
    }

    protected static function whatsapp(string $phone): string
    {
        return str($phone)->start('whatsapp:')->toString();
    }
}
