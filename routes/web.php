<?php

use App\Http\Controllers\Admin\DiseaseController as AdminDiseaseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiseaseAlertController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

/*

 Web Routes — Krishi Bondhu

 Phase 1: Authentication & Profile
 Phase 2: Public Home Page + Contact form
 Phase 3: Farmer Dashboard + placeholder module routes
 Phase 4: Crop Management (real module)
 Phase 5: Reminder Calendar (real module)
 Phase 6: Disease Alerts (real module) + first slice of the Admin area

 A note on the /admin group: this is a lightweight, standalone admin
 area for now — just enough to manage Diseases. Phase 15 wraps every
 admin sub-module built along the way (Diseases here, Tips in Phase 8,
 News in Phase 11, etc.) in one unified sidebar/dashboard shell. The
 controllers and routes built in each phase don't need to change for
 that — only the layout they render inside does.
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

    /*

     Placeholder module routes (still Phase 3 stand-ins)

       weather → Phase 7     tips     → Phase 8
       prices  → Phase 9     qa       → Phase 10
       news    → Phase 11    feedback → Phase 12
       fertilizer → Phase 13
    */
    Route::get('/weather', fn () => view('modules.coming-soon', ['title' => 'Weather', 'icon' => '⛅']))->name('weather.index');
    Route::get('/tips', fn () => view('modules.coming-soon', ['title' => 'Farming Tips', 'icon' => '💡']))->name('tips.index');
    Route::get('/prices', fn () => view('modules.coming-soon', ['title' => 'Crop Prices', 'icon' => '💰']))->name('prices.index');
    Route::get('/qa', fn () => view('modules.coming-soon', ['title' => 'Question & Answer', 'icon' => '❓']))->name('qa.index');
    Route::get('/news', fn () => view('modules.coming-soon', ['title' => 'Agriculture News', 'icon' => '📰']))->name('news.index');
    Route::get('/feedback', fn () => view('modules.coming-soon', ['title' => 'Feedback', 'icon' => '⭐']))->name('feedback.index');
    Route::get('/fertilizer', fn () => view('modules.coming-soon', ['title' => 'Fertilizer Guide', 'icon' => '🧪']))->name('fertilizer.index');

    /*

     Admin area (Phase 6 starts it with Disease management only)

    */
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('diseases', AdminDiseaseController::class)->except('show');
    });
});

require __DIR__.'/auth.php';
