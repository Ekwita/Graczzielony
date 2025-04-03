<?php

use App\Http\Controllers\Admin\BLog\BlogController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');

Route::post('/upload-image', function (Request $request) {
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('uploads', 'public');
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => asset('storage/' . $path)
            ]
        ]);
    }
    return response()->json(['success' => 0, 'error' => 'Błąd przesyłania pliku'], 400);
});