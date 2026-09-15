<?php

use Filament\Notifications\Notification;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentTwilio\FilamentTwilioServiceProvider;
use Twilio\Rest\Client;

it('boots the service provider', function () {
    expect(app()->getProviders(FilamentTwilioServiceProvider::class))->not->toBeEmpty();
});

it('merges the package config', function () {
    expect(config('filament-twilio'))
        ->toHaveKeys(['twilio_sid', 'twilio_token', 'twilio_sender']);
});

it('registers the sendToTwilioWhatsapp notification macro', function () {
    expect(Notification::hasMacro('sendToTwilioWhatsapp'))->toBeTrue();
});

it('resolves the Twilio client with the configured credentials', function () {
    (new FilamentTwilioServiceProvider(app()))->register();

    $client = app(Client::class);

    expect($client)->toBeInstanceOf(Client::class)
        ->and($client->getUsername())->toBe('AC00000000000000000000000000000000')
        ->and($client->getPassword())->toBe('test-token');
});

it('publishes the config file', function () {
    $paths = ServiceProvider::pathsToPublish(FilamentTwilioServiceProvider::class, 'filament-twilio-config');

    expect($paths)->toHaveCount(1)
        ->and(file_exists(array_key_first($paths)))->toBeTrue();
});
