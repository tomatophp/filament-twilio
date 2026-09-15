<?php

namespace TomatoPHP\FilamentTwilio\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TomatoPHP\FilamentTwilio\Services\Twilio;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

class NotifyTwilioWhatsappJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public ?Model $user;

    public ?string $message;

    public ?string $mediaURL;

    /**
     * @param  array{user: ?Model, message: ?string, mediaURL?: ?string}  $arrgs
     */
    public function __construct(array $arrgs)
    {
        $this->user = $arrgs['user'];
        $this->message = $arrgs['message'];
        $this->mediaURL = $arrgs['mediaURL'] ?? null;
    }

    /**
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function handle(): void
    {
        if (blank($this->user?->phone) || blank($this->message) || ! Twilio::isConfigured()) {
            return;
        }

        Twilio::send(
            phone: $this->user->phone,
            message: $this->message,
            mediaURL: $this->mediaURL
        );
    }
}
