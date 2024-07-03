<?php

namespace TomatoPHP\FilamentTwilio\Traits;

use TomatoPHP\FilamentTwilio\Jobs\NotifyTwilioWhatsappJob;

trait InteractsWithTwilioWhatsapp
{
    public function notifyTwilioWhatsapp(
        string $message,
        ?string $mediaURL=null,
    )
    {
        dispatch(new NotifyTwilioWhatsappJob([
            'user' => $this,
            'message' => $message,
            'mediaURL' => $mediaURL,
        ]));
    }
}
