<?php

namespace Filament\Notifications;
use Illuminate\Database\Eloquent\Model;

{
    /*
     * @method static notifyTwilioWhatsapp(Model $user)
     */
    class Notification
    {
        public function notifyTwilioWhatsapp(Model $user): static {}
    }
}
