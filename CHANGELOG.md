# Changelog

### v5.0.0

- support Filament v5 and Laravel 12 / 13 (the Filament v3 line continues on the `v3` branch)
- read the notification body (or the title when there is no body) through the Filament v5 notification API
- resolve the Twilio client from the container so it can be replaced in tests
- skip users without a phone number and skip sending while Twilio is not configured
- send the media URL as a list and do not double-prefix numbers that already start with `whatsapp:`
- remove an import of a class that does not exist (`TomatoPHP\FilamentFcm\Notifications\FCMNotificationService`)
- add a Pest suite (the Twilio HTTP client is faked), a phpstan config and the Laravel 12 / 13 CI matrix
- new cover
