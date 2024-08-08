<?php

use App\Http\Controllers\MainController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

if (app()->runningInConsole()) {
    app(Schedule::class)->call(function() {
        app(MainController::class)->dailyNotification();
    })->dailyAt('07:30');
}
