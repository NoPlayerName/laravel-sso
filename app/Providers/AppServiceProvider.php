<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $passportClass = 'Laravel\\Passport\\Passport';

        if (class_exists($passportClass)) {
            $passportClass::authorizationView('oauth.authorize');
        }
    }
}
