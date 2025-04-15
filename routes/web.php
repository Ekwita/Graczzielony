<?php

use App\Http\Controllers\Public\Ranking\ArchivedRankingController;
use App\Http\Controllers\Public\Ranking\RankingController;
use App\Http\Controllers\Public\Voting\SearchGameController;
use App\Http\Controllers\Public\Voting\VoteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Game ranking

Route::get('/search', [SearchGameController::class, 'search'])->name('game.search');
Route::get('/gra-miesiaca-glosowanie', [VoteController::class, 'index'])->name('vote.index');
Route::post('/vote/store', [VoteController::class, 'store'])->name('vote.store')->middleware(['throttle:vote']);

Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
Route::get('/ranking/archiwum', [ArchivedRankingController::class, 'index'])->name('ranking.archived');
Route::get('/ranking/archiwum/{id}', [ArchivedRankingController::class, 'show'])->name('ranking.show');



Route::inertia('/o-mnie', 'About')->name('about');

// Fallback
Route::fallback(function () {
    return Inertia::render('NotFound');
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
