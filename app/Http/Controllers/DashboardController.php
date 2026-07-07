<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    
    public function index(Request $request): View
    {
        $user = $request->user();

        // TODO (Phase 4): Crop::where('user_id', $user->id)->count();
        $cropCount = 0;
        // TODO (Phase 4): Crop::where('user_id', $user->id)->where('status', 'ready_for_harvest')->count();
        $cropsReadyCount = 0;
        // TODO (Phase 5): Task::where('user_id', $user->id)->whereDate('reminder_date', today())->count();
        $todaysReminderCount = 0;
        // TODO (Phase 6): Disease::count(), or a farmer-relevant subset if you add crop targeting later.
        $activeDiseaseAlerts = 0;
        // TODO (Phase 11): News::latest()->count(), or count published this week.
        $newsCount = 0;
        // TODO (Phase 11): the most recently published News record's title.
        $latestNewsTitle = null;
        // TODO (Phase 9): MarketPrice::count();
        $priceCount = 0;
        // TODO (Phase 10): Question::where('user_id', $user->id)->where('status', 'pending')->count();
        $pendingQuestions = 0;

        $modules = [
            [
                'key' => 'weather',
                'icon' => '⛅',
                'title' => 'Weather',
                // TODO (Phase 7): swap for a live one-line forecast, e.g. "28°C, Partly Cloudy in {city}".
                'summary' => 'Tap to see today\'s forecast for your location.',
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
                // TODO (Phase 8): swap for the featured Tip's title.
                'summary' => 'A new tip is waiting for you today.',
                'color' => 'yellow',
                'route' => 'tips.index',
            ],
            [
                'key' => 'diseases',
                'icon' => '🚨',
                'title' => 'Disease Alerts',
                'summary' => "{$activeDiseaseAlerts} active disease alerts published",
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
