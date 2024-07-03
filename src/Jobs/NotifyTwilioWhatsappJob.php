<?php

namespace TomatoPHP\FilamentTwilio\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use TomatoPHP\FilamentFcm\Notifications\FCMNotificationService;
use TomatoPHP\FilamentTwilio\Services\Twilio;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

class NotifyTwilioWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?Model $user;
    public ?string $message;
    public ?bool $sendToDatabase = true;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arrgs)
    {
        $this->user = $arrgs['user'];
        $this->message  = $arrgs['message'];
    }


    /**
     * @return void
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function handle(): void
    {
        if($this->user->phone){
            Twilio::send($this->user->phone, $this->message);
        }
    }
}
