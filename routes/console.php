<?php

use App\Actions\ArchiveTopGames;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(ArchiveTopGames::class)->everyMinute();
// Schedule::call(ArchiveTopGames::class)->monthly();

