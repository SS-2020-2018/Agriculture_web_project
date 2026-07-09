<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;


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

    // Crop Management (Phase 4)
    Route::resource('crops', CropController::class);

    /*
    
    Reminder Calendar (Phase 5) — real module
    
    Everything happens inline on one page (add via sidebar form, edit
    re-populates that same form via JS, toggle is a small AJAX call
    from the checkbox) — so there's no create/show/edit route, just
    index/store/update/toggle/destroy.
    */
    Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('/reminders', [ReminderController::class, 'store'])->name('reminders.store');
    Route::put('/reminders/{reminder}', [ReminderController::class, 'update'])->name('reminders.update');
    Route::patch('/reminders/{reminder}/toggle', [ReminderController::class, 'toggle'])->name('reminders.toggle');
    Route::delete('/reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');

    /*
    
    Placeholder module routes
    
      diseases → Phase 6    weather   → Phase 7
      tips     → Phase 8    prices    → Phase 9
      qa       → Phase 10   news      → Phase 11
      feedback → Phase 12   fertilizer → Phase 13
    */
    Route::get('/weather', fn () => view('modules.coming-soon', ['title' => 'Weather', 'icon' => '⛅']))->name('weather.index');
    Route::get('/tips', fn () => view('modules.coming-soon', ['title' => 'Farming Tips', 'icon' => '💡']))->name('tips.index');
    Route::get('/diseases', fn () => view('modules.coming-soon', ['title' => 'Disease Alerts', 'icon' => '🚨']))->name('diseases.index');
    Route::get('/prices', fn () => view('modules.coming-soon', ['title' => 'Crop Prices', 'icon' => '💰']))->name('prices.index');
    Route::get('/qa', fn () => view('modules.coming-soon', ['title' => 'Question & Answer', 'icon' => '❓']))->name('qa.index');
    Route::get('/news', fn () => view('modules.coming-soon', ['title' => 'Agriculture News', 'icon' => '📰']))->name('news.index');
    Route::get('/feedback', fn () => view('modules.coming-soon', ['title' => 'Feedback', 'icon' => '⭐']))->name('feedback.index');
    Route::get('/fertilizer', fn () => view('modules.coming-soon', ['title' => 'Fertilizer Guide', 'icon' => '🧪']))->name('fertilizer.index');
});

require __DIR__.'/auth.php';
