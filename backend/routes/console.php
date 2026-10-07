<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/*
|--------------------------------------------------------------------------
| CRM Scheduled Commands
|--------------------------------------------------------------------------
| These will be expanded as business modules are added.
*/

// Example: cleanup expired tokens daily at midnight
Schedule::command('sanctum:prune-expired --hours=24')->daily()->at('00:00');
