<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /*
      Display the public Home Page.
     */
    public function index(): View
    {
        $services = [
            ['icon' => '⛅', 'title' => 'Weather Information', 'description' => 'Live weather, forecasts, and alerts tailored to your location.', 'color' => 'blue'],
            ['icon' => '🌱', 'title' => 'Crop Management', 'description' => 'Track every crop from planting to harvest in one place.', 'color' => 'green'],
            ['icon' => '🚨', 'title' => 'Disease Alerts', 'description' => 'Spot crop diseases early with symptoms, causes, and treatments.', 'color' => 'red'],
            ['icon' => '🧪', 'title' => 'Fertilizer Guide', 'description' => 'Find the right fertilizer, dosage, and timing for any crop.', 'color' => 'purple'],
            ['icon' => '💰', 'title' => 'Market Price Information', 'description' => 'Check the latest crop prices before you buy or sell.', 'color' => 'yellow'],
            ['icon' => '💡', 'title' => 'Farming Tips', 'description' => 'Daily tips from agricultural experts to boost your yield.', 'color' => 'orange'],
            ['icon' => '❓', 'title' => 'Question & Answer Support', 'description' => 'Ask questions and get direct answers from our administrators.', 'color' => 'teal'],
            ['icon' => '📅', 'title' => 'Reminder Calendar', 'description' => 'Never miss watering, spraying, or harvesting days again.', 'color' => 'indigo'],
            ['icon' => '📰', 'title' => 'Agriculture News', 'description' => 'Stay updated on rain alerts, government notices, and more.', 'color' => 'blue'],
            ['icon' => '⭐', 'title' => 'Feedback System', 'description' => 'Share your experience and help us improve Krishi Bondhu.', 'color' => 'green'],
        ];

        $stats = [
            ['count' => 500, 'suffix' => '+', 'label' => 'Registered Farmers'],
            ['count' => 64, 'suffix' => '', 'label' => 'Districts Covered'],
            ['count' => 10, 'suffix' => '', 'label' => 'Smart Modules'],
            ['count' => 24, 'suffix' => '/7', 'label' => 'Support Available'],
        ];

        return view('home', compact('services', 'stats'));
    }
}
