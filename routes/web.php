<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Public home page (full marketing page arrives in Phase 2)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    // Farmer dashboard (placeholder here — full card dashboard is Phase 3)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile: view (read-only) + edit (form) + update + delete account
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
