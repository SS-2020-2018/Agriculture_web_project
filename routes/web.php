<?php

use App\Http\Controllers\Admin\AnswerController as AdminAnswerController;
use App\Http\Controllers\Admin\DiseaseController as AdminDiseaseController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\MarketPriceController as AdminMarketPriceController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\TipController as AdminTipController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiseaseAlertController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketPriceController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QAController;
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
 Phase 9: Crop Price Information (real module)
 Phase 10: Question & Answer Forum (real module)
 Phase 11: Agriculture News (real module)
 Phase 12: Feedback System (real module — replaces feedback placeholder)
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

    // Notifications (Phase 8)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/open', [NotificationController::class, 'open'])->name('notifications.open');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Crop Price Information — farmer-facing browsing (Phase 9)
    Route::get('/prices', [MarketPriceController::class, 'index'])->name('prices.index');
    Route::get('/prices/{price}', [MarketPriceController::class, 'show'])->name('prices.show');

    // Question & Answer Forum — farmer-facing (Phase 10)
    Route::get('/qa', [QAController::class, 'index'])->name('qa.index');
    Route::post('/qa', [QAController::class, 'store'])->name('qa.store');
    Route::post('/qa/answers/{answer}/like', [QAController::class, 'toggleAnswerLike'])->name('qa.answers.like');

    // Agriculture News — farmer-facing browsing (Phase 11)
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

    // Feedback System (Phase 12)
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::put('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // Placeholder module route — fertilizer → Phase 13
    Route::get('/fertilizer', fn () => view('modules.coming-soon', ['title' => 'Fertilizer Guide', 'icon' => '🧪']))->name('fertilizer.index');

    // Admin area (Diseases, Tips, Crop Prices, Q&A, News, and now Feedback)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('diseases', AdminDiseaseController::class)->except('show');

        Route::resource('tips', AdminTipController::class)->except('show');
        Route::get('/tips/{tip}/likers', [AdminTipController::class, 'likers'])->name('tips.likers');

        Route::resource('prices', AdminMarketPriceController::class)->except('show');

        Route::get('/qa', [AdminQuestionController::class, 'index'])->name('qa.index');
        Route::get('/qa/{question}', [AdminQuestionController::class, 'show'])->name('qa.show');
        Route::post('/qa/{question}/answer', [AdminAnswerController::class, 'store'])->name('qa.answer');

        Route::resource('news', AdminNewsController::class)->except('show');

        Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
        Route::patch('/feedback/{feedback}/review', [AdminFeedbackController::class, 'markReviewed'])->name('feedback.review');
    });
});

require __DIR__.'/auth.php';
