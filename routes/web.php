<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*

 Web Routes — Krishi Bondhu

 Phase 1: Authentication & Profile
 Phase 2: Public Home Page + Contact form
 Phase 3: Farmer Dashboard + placeholder module routes
 Phase 4: Crop Management (real module — replaces the crops placeholder)

*/

// Public Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form submission (public — no auth required)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {

    // Farmer Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile: view (read-only) + edit (form) + update + delete account
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    
     Crop Management
     Generates: crops.index, crops.create, crops.store, crops.show,
     crops.edit, crops.update, crops.destroy.
    */
    Route::resource('crops', CropController::class);

    // Placeholder routes for the other modules (coming soon)
    Route::get('/weather', fn () => view('modules.coming-soon', ['title' => 'Weather', 'icon' => '⛅']))->name('weather.index');
    Route::get('/tips', fn () => view('modules.coming-soon', ['title' => 'Farming Tips', 'icon' => '💡']))->name('tips.index');
    Route::get('/diseases', fn () => view('modules.coming-soon', ['title' => 'Disease Alerts', 'icon' => '🚨']))->name('diseases.index');
    Route::get('/reminders', fn () => view('modules.coming-soon', ['title' => 'Reminder Calendar', 'icon' => '📅']))->name('reminders.index');
    Route::get('/prices', fn () => view('modules.coming-soon', ['title' => 'Crop Prices', 'icon' => '💰']))->name('prices.index');
    Route::get('/qa', fn () => view('modules.coming-soon', ['title' => 'Question & Answer', 'icon' => '❓']))->name('qa.index');
    Route::get('/news', fn () => view('modules.coming-soon', ['title' => 'Agriculture News', 'icon' => '📰']))->name('news.index');
    Route::get('/feedback', fn () => view('modules.coming-soon', ['title' => 'Feedback', 'icon' => '⭐']))->name('feedback.index');
    Route::get('/fertilizer', fn () => view('modules.coming-soon', ['title' => 'Fertilizer Guide', 'icon' => '🧪']))->name('fertilizer.index');
});

require __DIR__.'/auth.php';
