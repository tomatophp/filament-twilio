<?php

namespace Filament\Notifications;
use Illuminate\Database\Eloquent\Model;

{
    /*
     * @method static sendToTwilioWhatsapp(Model $user, ?string $mediaURL = null)
     */
    class Notification
    {
        public function sendToTwilioWhatsapp(Model $user, ?string $mediaURL = null): static {}
    }
}
