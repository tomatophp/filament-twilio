<?php

namespace TomatoPHP\FilamentTwilio\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use TomatoPHP\FilamentTwilio\FilamentTwilioServiceProvider;
use TomatoPHP\FilamentTwilio\Tests\Fakes\FakeTwilioHttpClient;
use Twilio\Rest\Client;

#[WithEnv('DB_CONNECTION', 'testing')]
abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected FakeTwilioHttpClient $twilioHttp;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twilioHttp = new FakeTwilioHttpClient;

        $this->app->bind(Client::class, fn (): Client => new Client(
            config('filament-twilio.twilio_sid'),
            config('filament-twilio.twilio_token'),
            httpClient: $this->twilioHttp,
        ));
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentTwilioServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('queue.default', 'sync');
        $app['config']->set('filament-twilio.twilio_sid', 'AC00000000000000000000000000000000');
        $app['config']->set('filament-twilio.twilio_token', 'test-token');
        $app['config']->set('filament-twilio.twilio_sender', '+15005550006');
    }
}
