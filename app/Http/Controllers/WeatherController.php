<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeatherController extends Controller
{
    public function __construct(private readonly WeatherService $weatherService)
    {
    }

    /*
     Display the Weather Dashboard. If a ?city= query string is present,
     we geocode and look up that city; otherwise we auto-detect the
     visitor's location from their IP address.
     */
    public function index(Request $request): View
    {
        $city = trim((string) $request->query('city', ''));
        $weather = null;
        $errorMessage = null;

        if ($city !== '') {
            $location = $this->weatherService->geocodeCity($city);

            if (! $location) {
                $errorMessage = "We couldn't find a location called \"{$city}\". Please check the spelling and try again.";
            }
        } else {
            $location = $this->weatherService->detectLocationFromIp();

            if (! $location) {
                $errorMessage = "We couldn't automatically detect your location. Please search for your city below.";
            }
        }

        if (! empty($location)) {
            $weather = $this->weatherService->getCurrentWeather($location['lat'], $location['lon']);

            if (! $weather) {
                $errorMessage = 'The weather service is temporarily unavailable. Please try again in a moment.';
            } else {
                $this->rememberRecentSearch($weather['city'], $weather['country']);
            }
        }

        return view('weather.index', [
            'weather' => $weather,
            'errorMessage' => $errorMessage,
            'searchedCity' => $city,
            'recentSearches' => session('recent_weather_searches', []),
        ]);
    }

    /*
      Keep a small, de-duplicated list of recently viewed locations in
      the session so the farmer can quickly jump back to them.
     */
    private function rememberRecentSearch(string $city, ?string $country): void
    {
        $label = $country ? "{$city}, {$country}" : $city;

        $recent = session('recent_weather_searches', []);
        $recent = array_values(array_filter($recent, fn ($item) => $item !== $label));
        array_unshift($recent, $label);
        $recent = array_slice($recent, 0, 5);

        session(['recent_weather_searches' => $recent]);
    }
}
