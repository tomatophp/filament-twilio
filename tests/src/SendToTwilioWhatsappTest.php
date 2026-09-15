<?php

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Queue;
use TomatoPHP\FilamentTwilio\Jobs\NotifyTwilioWhatsappJob;
use TomatoPHP\FilamentTwilio\Services\Twilio;
use TomatoPHP\FilamentTwilio\Tests\Models\User;

function twilioUser(?string $phone = '+201000000000'): User
{
    return User::query()->create([
        'name' => 'Fady',
        'email' => 'fady@example.com',
        'password' => 'secret',
        'phone' => $phone,
    ]);
}

it('sends a WhatsApp message from a native Filament notification', function () {
    Notification::make()
        ->title('Ignored title')
        ->body('Your order is ready')
        ->sendToTwilioWhatsapp(twilioUser());

    expect($this->twilioHttp->requests)->toHaveCount(1);

    $request = $this->twilioHttp->requests[0];

    expect($request['method'])->toBe('POST')
        ->and($request['url'])->toBe('https://api.twilio.com/2010-04-01/Accounts/AC00000000000000000000000000000000/Messages.json')
        ->and($request['data']['To'])->toBe('whatsapp:+201000000000')
        ->and($request['data']['From'])->toBe('whatsapp:+15005550006')
        ->and($request['data']['Body'])->toBe('Your order is ready');
});

it('attaches the media url', function () {
    Notification::make()
        ->body('Look at this')
        ->sendToTwilioWhatsapp(twilioUser(), mediaURL: 'https://example.com/photo.jpg');

    expect($this->twilioHttp->requests[0]['data']['MediaUrl'])->toBe(['https://example.com/photo.jpg']);
});

it('uses the title when the notification has no body', function () {
    Notification::make()
        ->title('Only a title')
        ->sendToTwilioWhatsapp(twilioUser());

    expect($this->twilioHttp->requests[0]['data']['Body'])->toBe('Only a title');
});

it('sends from the model trait directly', function () {
    twilioUser()->notifyTwilioWhatsapp(message: 'Direct message');

    expect($this->twilioHttp->requests[0]['data']['Body'])->toBe('Direct message');
});

it('returns the twilio message sid', function () {
    expect(Twilio::send('+201000000000', 'Hello'))->toStartWith('SM');
});

it('does not prefix a number that already has the whatsapp prefix', function () {
    Twilio::send('whatsapp:+201000000000', 'Hello');

    expect($this->twilioHttp->requests[0]['data']['To'])->toBe('whatsapp:+201000000000');
});

it('skips users without a phone number', function () {
    twilioUser(phone: null)->notifyTwilioWhatsapp(message: 'Nobody to send to');

    expect($this->twilioHttp->requests)->toBeEmpty();
});

it('skips sending while Twilio is not configured', function () {
    config()->set('filament-twilio.twilio_token', null);

    twilioUser()->notifyTwilioWhatsapp(message: 'Not configured');

    expect(Twilio::isConfigured())->toBeFalse()
        ->and($this->twilioHttp->requests)->toBeEmpty();
});

it('queues the job when the queue is not sync', function () {
    Queue::fake();

    twilioUser()->notifyTwilioWhatsapp(message: 'Queued');

    Queue::assertPushed(NotifyTwilioWhatsappJob::class, fn (NotifyTwilioWhatsappJob $job): bool => $job->message === 'Queued');
    expect($this->twilioHttp->requests)->toBeEmpty();
});

it('returns the notification for chaining', function () {
    $notification = Notification::make()->body('Chained');

    expect($notification->sendToTwilioWhatsapp(twilioUser()))->toBe($notification);
});
