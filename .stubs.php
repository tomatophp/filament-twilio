<?php

namespace Filament\Notifications;
use Illuminate\Database\Eloquent\Model;

{
    /*
     * @method static sendToTwilioWhatsapp(Model $user)
     */
    class Notification
    {
        public function sendToTwilioWhatsapp(Model $user): static {}
    }
}
