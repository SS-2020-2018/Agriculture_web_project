<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Crop;
use App\Models\Disease;
use App\Models\Feedback;
use App\Models\Fertilizer;
use App\Models\MarketPrice;
use App\Models\News;
use App\Models\Question;
use App\Models\Tip;
use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly WeatherService $weatherService)
    {
    }

    /**
     * The Admin Dashboard: summary stat cards (each clickable through to
     * its management page) plus recent-activity feeds across the app.
     */
    public function index(): View
    {
        $stats = [
            'farmers' => User::where('role', 'farmer')->count(),
            'crops' => Crop::count(),
            'todays_questions' => Question::whereDate('created_at', today())->count(),
            'news' => News::count(),
            'feedback' => Feedback::count(),
            'diseases' => Disease::count(),
            'fertilizers' => Fertilizer::count(),
            'tips' => Tip::count(),
            'prices' => MarketPrice::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        // Same cache key the farmer dashboard uses (Phase 7) — both are
        // showing "current weather for this server's location", so
        // there's no reason to fetch it twice.
        $weatherSummary = Cache::remember('dashboard-weather-summary', now()->addMinutes(30), function () {
            $location = $this->weatherService->detectLocationFromIp();

            if (! $location) {
                return null;
            }

            $weather = $this->weatherService->getCurrentWeather($location['lat'], $location['lon']);

            if (! $weather) {
                return null;
            }

            return "{$weather['temp']}°C, {$weather['condition']} in {$weather['city']}";
        });

        $recentFarmers = User::where('role', 'farmer')->with('profile')->latest()->take(5)->get();
        $recentFeedback = Feedback::with('user')->latest()->take(5)->get();
        $latestQuestions = Question::with('farmer')->latest()->take(5)->get();
        $latestNews = News::latest()->take(5)->get();
        $recentPrices = MarketPrice::latest('updated_at')->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'weatherSummary' => $weatherSummary,
            'recentFarmers' => $recentFarmers,
            'recentFeedback' => $recentFeedback,
            'latestQuestions' => $latestQuestions,
            'latestNews' => $latestNews,
            'recentPrices' => $recentPrices,
            'recentMessages' => $recentMessages,
        ]);
    }
}
