<?php

namespace TomatoPHP\FilamentTwilio\Traits;

use TomatoPHP\FilamentTwilio\Jobs\NotifyTwilioWhatsappJob;

trait InteractsWithTwilioWhatsapp
{
    /**
     * Send a WhatsApp message to the model's `phone` column through Twilio.
     */
    public function notifyTwilioWhatsapp(
        string $message,
        ?string $mediaURL = null,
    ): void {
        dispatch(new NotifyTwilioWhatsappJob([
            'user' => $this,
            'message' => $message,
            'mediaURL' => $mediaURL,
        ]));
    }
}
