<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\MarketPrice;
use App\Models\News;
use App\Models\Question;
use App\Models\Task;
use App\Models\Tip;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly WeatherService $weatherService)
    {
    }

    /*
      Display the Farmer Dashboard — a personalized welcome message plus
      a grid of clickable module cards. Each card's summary is wired to
      a placeholder value for now; the TODO comments mark exactly which
      future phase replaces that value with a real Eloquent query.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Phase 4: wired to real data.
        $cropCount = Crop::where('user_id', $user->id)->count();
        $cropsReadyCount = Crop::where('user_id', $user->id)->where('status', 'ready_for_harvest')->count();

        // Phase 5: wired to real data.
        $todaysReminderCount = Task::where('user_id', $user->id)->whereDate('reminder_date', today())->count();

        // Phase 6: wired to real data.
        $activeDiseaseAlerts = Disease::count();

        // Phase 7: wired to real data, cached for 30 minutes so the
        // dashboard doesn't hit the weather API on every single page load.
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

        // Phase 8: wired to real data — today's featured tip is simply
        // the most recently published one.
        $latestTip = Tip::latest()->first();

        // Phase 9: wired to real data.
        $priceCount = MarketPrice::count();

        // Phase 10: wired to real data.
        $pendingQuestions = Question::where('user_id', $user->id)->where('status', 'pending')->count();

        // Phase 11: wired to real data.
        $newsCount = News::count();
        $latestNewsTitle = News::latest()->first()?->title;

        $modules = [
            [
                'key' => 'weather',
                'icon' => '⛅',
                'title' => 'Weather',
                'summary' => $weatherSummary ?? 'Tap to see today\'s forecast for your location.',
                'color' => 'blue',
                'route' => 'weather.index',
            ],
            [
                'key' => 'crops',
                'icon' => '🌱',
                'title' => 'Crops',
                'summary' => "{$cropCount} crops registered • {$cropsReadyCount} ready for harvest",
                'color' => 'green',
                'route' => 'crops.index',
            ],
            [
                'key' => 'tips',
                'icon' => '💡',
                'title' => "Today's Farming Tip",
                'summary' => $latestTip ? $latestTip->title : 'No farming tips published yet.',
                'color' => 'yellow',
                'route' => 'tips.index',
            ],
            [
                'key' => 'diseases',
                'icon' => '🚨',
                'title' => 'Disease Alerts',
                'summary' => "{$activeDiseaseAlerts} disease alerts published",
                'color' => 'red',
                'route' => 'diseases.index',
            ],
            [
                'key' => 'reminders',
                'icon' => '📅',
                'title' => 'Reminder Calendar',
                'summary' => "{$todaysReminderCount} tasks scheduled for today",
                'color' => 'indigo',
                'route' => 'reminders.index',
            ],
            [
                'key' => 'prices',
                'icon' => '💰',
                'title' => 'Crop Prices',
                'summary' => "{$priceCount} market prices available",
                'color' => 'orange',
                'route' => 'prices.index',
            ],
            [
                'key' => 'qa',
                'icon' => '❓',
                'title' => 'Question & Answer',
                'summary' => "{$pendingQuestions} of your questions awaiting a reply",
                'color' => 'teal',
                'route' => 'qa.index',
            ],
            [
                'key' => 'news',
                'icon' => '📰',
                'title' => 'Agriculture News',
                'summary' => $latestNewsTitle ?? "{$newsCount} news articles published",
                'color' => 'cyan',
                'route' => 'news.index',
            ],
            [
                'key' => 'feedback',
                'icon' => '⭐',
                'title' => 'Feedback',
                'summary' => 'Tell us what you think of Krishi Bondhu.',
                'color' => 'pink',
                'route' => 'feedback.index',
            ],
            [
                'key' => 'fertilizer',
                'icon' => '🧪',
                'title' => 'Fertilizer Guide',
                'summary' => 'Find the right fertilizer for any crop.',
                'color' => 'purple',
                'route' => 'fertilizer.index',
            ],
        ];

        return view('dashboard', compact('user', 'modules'));
    }
}
