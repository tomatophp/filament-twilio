![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-twilio/master/arts/3x1io-tomato-twilio.jpg)

# Filament Twilio

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-twilio/version.svg)](https://packagist.org/packages/tomatophp/filament-twilio)
[![License](https://poser.pugx.org/tomatophp/filament-twilio/license.svg)](https://packagist.org/packages/tomatophp/filament-twilio)
[![Downloads](https://poser.pugx.org/tomatophp/filament-twilio/d/total.svg)](https://packagist.org/packages/tomatophp/filament-twilio)

Send Whatsapp messages using Twilio and native filament Notification Facade class

## Screenshots

![Message](https://raw.githubusercontent.com/tomatophp/filament-twilio/master/arts/message.png)

## Installation

```bash
composer require tomatophp/filament-twilio
```

## Using

first of all you need to add this variables to your `.env` file

```dotenv
TWILIO_SID=
TWILIO_TOKEN=
TWILIO_SENDER_NUMBER=
```

then clear you cache

```bash
php artisan config:cache
```

now on your User model add this trait

```php
use TomatoPHP\FilamentTwilio\Traits\InteractsWithTwilioWhatsapp;

class User extends Authenticatable
{
    use InteractsWithTwilioWhatsapp;
}
```

now you are ready to use the notification

```php

\Filament\Notifications\Notification::make()
    ->body('Your Message You Like To Send Here!')
    ->sendToTwilioWhatsapp(
        user: $user,
        mediaURL: "https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80"
    );
```

or you can use it from user model direct

```php
$user->notifyTwilioWhatsapp(
    message: 'Your Message You Like To Send Here!',
    mediaURL: "https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80"
);
```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-twilio-config"
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
