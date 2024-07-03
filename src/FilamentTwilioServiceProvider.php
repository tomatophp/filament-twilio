<?php

namespace TomatoPHP\FilamentTwilio;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;


class FilamentTwilioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-twilio.php', 'filament-twilio');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-twilio.php' => config_path('filament-twilio.php'),
        ], 'filament-twilio-config');

    }

    public function boot(): void
    {
        Notification::macro('sendToTwilioWhatsapp', function (Model $user, ?string $mediaURL=null): static
        {
            /** @var Notification $this */
            $user->notifyTwilioWhatsapp(
                message: $this->body,
                mediaURL: $mediaURL
            );

            return $this;
        });
    }
}
