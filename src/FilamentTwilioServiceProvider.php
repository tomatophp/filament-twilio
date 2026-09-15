<?php

namespace TomatoPHP\FilamentTwilio;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class FilamentTwilioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-twilio.php', 'filament-twilio');

        $this->publishes([
            __DIR__ . '/../config/filament-twilio.php' => config_path('filament-twilio.php'),
        ], 'filament-twilio-config');

        $this->app->bind(Client::class, fn (): Client => new Client(
            config('filament-twilio.twilio_sid'),
            config('filament-twilio.twilio_token'),
        ));
    }

    public function boot(): void
    {
        Notification::macro('sendToTwilioWhatsapp', function (Model $user, ?string $mediaURL = null): static {
            /** @var Notification $this */
            $user->notifyTwilioWhatsapp(
                message: (string) ($this->getBody() ?: $this->getTitle()),
                mediaURL: $mediaURL
            );

            return $this;
        });
    }
}
