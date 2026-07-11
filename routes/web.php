<?php

use App\Http\Controllers\Admin\DiseaseController as AdminDiseaseController;
use App\Http\Controllers\Admin\TipController as AdminTipController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiseaseAlertController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SavedTipController;
use App\Http\Controllers\TipController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

/*

 Web Routes — Krishi Bondhu

 Phase 1: Authentication & Profile
 Phase 2: Public Home Page + Contact form
 Phase 3: Farmer Dashboard + placeholder module routes
 Phase 4: Crop Management (real module)
 Phase 5: Reminder Calendar (real module)
 Phase 6: Disease Alerts (real module) + first slice of the Admin area
 Phase 7: Weather Information (real module)
 Phase 8: Farming Tips + Saved Tips + Notifications (real modules)
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

    // Crop Management (Phase 4)
    Route::resource('crops', CropController::class);

    // Reminder Calendar (Phase 5)
    Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('/reminders', [ReminderController::class, 'store'])->name('reminders.store');
    Route::put('/reminders/{reminder}', [ReminderController::class, 'update'])->name('reminders.update');
    Route::patch('/reminders/{reminder}/toggle', [ReminderController::class, 'toggle'])->name('reminders.toggle');
    Route::delete('/reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');

    // Disease Alerts — farmer-facing browsing (Phase 6)
    Route::get('/diseases', [DiseaseAlertController::class, 'index'])->name('diseases.index');
    Route::get('/diseases/{disease}', [DiseaseAlertController::class, 'show'])->name('diseases.show');

    // Weather Information (Phase 7)
    Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');

    // Farming Tips (Phase 8)
    Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
    Route::get('/tips/{tip}', [TipController::class, 'show'])->name('tips.show');
    Route::post('/tips/{tip}/like', [TipController::class, 'toggleLike'])->name('tips.like');

    // Saved Tips (Phase 8)
    Route::get('/saved-tips', [SavedTipController::class, 'index'])->name('saved-tips.index');
    Route::post('/tips/{tip}/save', [SavedTipController::class, 'store'])->name('saved-tips.store');
    Route::delete('/saved-tips/{savedTip}', [SavedTipController::class, 'destroy'])->name('saved-tips.destroy');

    // Notifications (Phase 8 — also powers Phase 10's Q&A reply alerts)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/open', [NotificationController::class, 'open'])->name('notifications.open');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    /*
    
     Placeholder module routes (still Phase 3 stand-ins)
    
       prices → Phase 9      qa        → Phase 10
       news   → Phase 11     feedback  → Phase 12
       fertilizer → Phase 13
    */
    Route::get('/prices', fn () => view('modules.coming-soon', ['title' => 'Crop Prices', 'icon' => '💰']))->name('prices.index');
    Route::get('/qa', fn () => view('modules.coming-soon', ['title' => 'Question & Answer', 'icon' => '❓']))->name('qa.index');
    Route::get('/news', fn () => view('modules.coming-soon', ['title' => 'Agriculture News', 'icon' => '📰']))->name('news.index');
    Route::get('/feedback', fn () => view('modules.coming-soon', ['title' => 'Feedback', 'icon' => '⭐']))->name('feedback.index');
    Route::get('/fertilizer', fn () => view('modules.coming-soon', ['title' => 'Fertilizer Guide', 'icon' => '🧪']))->name('fertilizer.index');

    // Admin area (Diseases from Phase 6, Tips added in Phase 8)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('diseases', AdminDiseaseController::class)->except('show');

        Route::resource('tips', AdminTipController::class)->except('show');
        Route::get('/tips/{tip}/likers', [AdminTipController::class, 'likers'])->name('tips.likers');
    });
});

require __DIR__.'/auth.php';
