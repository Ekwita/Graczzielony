<?php

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


Route::get('/search', [SearchGameController::class, 'search'])->name('game.search');
Route::get('/vote', [VoteController::class, 'index'])->name('vote.index');
Route::post('/vote/store', [VoteController::class, 'store'])->name('vote.store');

Route::inertia('/about', 'About');



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
