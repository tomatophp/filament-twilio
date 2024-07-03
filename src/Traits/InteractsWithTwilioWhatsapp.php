<?php

namespace TomatoPHP\FilamentTwilio\Traits;

use TomatoPHP\FilamentTwilio\Jobs\NotifyTwilioWhatsappJob;

trait InteractsWithTwilioWhatsapp
{
    public function notifyTwilioWhatsapp(
        string $message
    )
    {
        dispatch(new NotifyTwilioWhatsappJob([
            'user' => $this,
            'message' => $message
        ]));
    }
}
