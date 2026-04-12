<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

Artisan::command('app:hello', function (): int {
    $this->comment('Laravel SSO is running.');

    return self::SUCCESS;
})->purpose('Show a simple application status message.');
