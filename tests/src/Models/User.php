<?php

namespace TomatoPHP\FilamentTwilio\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use TomatoPHP\FilamentTwilio\Traits\InteractsWithTwilioWhatsapp;

/**
 * @property ?string $phone
 */
class User extends Authenticatable
{
    use InteractsWithTwilioWhatsapp;

    protected $guarded = [];

    protected $table = 'users';
}
