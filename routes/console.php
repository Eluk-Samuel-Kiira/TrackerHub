<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule::command('backup:run')->everyFiveDays()->at('01:30');
// Schedule::command('backup:run')->everyMinute()->at('00:30');
Schedule::command('backup:run')->cron('30 1 */5 * *');

