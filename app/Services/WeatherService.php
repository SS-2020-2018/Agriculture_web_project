<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    private Client $client;

    private ?string $apiKey;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 8]);
        $this->apiKey = config('services.openweathermap.key');
    }

    /*
    Detect the visitor's approximate location from their public IP,
     using the free IP-API service. Used when no city is searched.
     
    Note: in local development, this resolves to your machine's own
     public IP (via your ISP), not to 127.0.0.1 — which is exactly
     what we want for testing "auto-detect my location".
     
     @return array{lat: float, lon: float, city: ?string}|null
     */
    public function detectLocationFromIp(): ?array
    {
        try {
            $response = $this->client->get('http://ip-api.com/json/', [
                'query' => ['fields' => 'status,message,city,lat,lon'],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (($data['status'] ?? null) !== 'success') {
                return null;
            }

            return [
                'lat' => (float) $data['lat'],
                'lon' => (float) $data['lon'],
                'city' => $data['city'] ?? null,
            ];
        } catch (GuzzleException $e) {
            Log::warning('IP-API location detection failed: '.$e->getMessage());

            return null;
        }
    }

    /*
     Convert a city name into coordinates using OpenWeatherMap's
     Geocoding API. Returns null if the city can't be found or the
     API call fails for any reason.
     
     @return array{lat: float, lon: float, name: string, country: ?string}|null
     */
    public function geocodeCity(string $city): ?array
    {
        try {
            $response = $this->client->get('https://api.openweathermap.org/geo/1.0/direct', [
                'query' => [
                    'q' => $city,
                    'limit' => 1,
                    'appid' => $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data)) {
                return null;
            }

            return [
                'lat' => (float) $data[0]['lat'],
                'lon' => (float) $data[0]['lon'],
                'name' => $data[0]['name'],
                'country' => $data[0]['country'] ?? null,
            ];
        } catch (GuzzleException $e) {
            Log::warning('OpenWeatherMap geocoding failed: '.$e->getMessage());

            return null;
        }
    }

    /*
     Fetch and format current weather conditions for a coordinate pair.
    
     @return array<string, mixed>|null
     */
    public function getCurrentWeather(float $lat, float $lon): ?array
    {
        try {
            $response = $this->client->get('https://api.openweathermap.org/data/2.5/weather', [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $this->formatWeatherData($data);
        } catch (GuzzleException $e) {
            Log::warning('OpenWeatherMap current-weather fetch failed: '.$e->getMessage());

            return null;
        }
    }

    /*
      Reshape OpenWeatherMap's raw JSON into a flat, Blade-friendly array
     containing every field the Weather Dashboard needs to display.
    
      @return array<string, mixed>
     */
    private function formatWeatherData(array $data): array
    {
        $tzOffsetSeconds = $data['timezone'] ?? 0;
        $icon = $data['weather'][0]['icon'] ?? '01d';

        return [
            'city' => $data['name'] ?? 'Unknown',
            'country' => $data['sys']['country'] ?? null,
            'lat' => $data['coord']['lat'] ?? null,
            'lon' => $data['coord']['lon'] ?? null,

            'temp' => round($data['main']['temp'] ?? 0),
            'feels_like' => round($data['main']['feels_like'] ?? 0),
            'temp_min' => round($data['main']['temp_min'] ?? 0),
            'temp_max' => round($data['main']['temp_max'] ?? 0),

            'condition' => $data['weather'][0]['main'] ?? 'N/A',
            'description' => ucfirst($data['weather'][0]['description'] ?? ''),
            'icon_url' => "https://openweathermap.org/img/wn/{$icon}@2x.png",

            'humidity' => $data['main']['humidity'] ?? null,
            'pressure' => $data['main']['pressure'] ?? null,
            'visibility_km' => isset($data['visibility']) ? round($data['visibility'] / 1000, 1) : null,
            'clouds' => $data['clouds']['all'] ?? null,

            'wind_speed' => $data['wind']['speed'] ?? null,
            'wind_direction' => $this->windDirectionLabel($data['wind']['deg'] ?? null),

            'sunrise' => isset($data['sys']['sunrise'])
                ? Carbon::createFromTimestamp($data['sys']['sunrise'], 'UTC')->addSeconds($tzOffsetSeconds)->format('h:i A')
                : 'N/A',
            'sunset' => isset($data['sys']['sunset'])
                ? Carbon::createFromTimestamp($data['sys']['sunset'], 'UTC')->addSeconds($tzOffsetSeconds)->format('h:i A')
                : 'N/A',

            'timezone_label' => $this->timezoneOffsetLabel($tzOffsetSeconds),
        ];
    }

    /*
     Convert a wind direction in degrees to a compass label (N, NE, etc).
     */
    private function windDirectionLabel(?int $degrees): string
    {
        if ($degrees === null) {
            return 'N/A';
        }

        $directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
        $index = (int) round($degrees / 22.5) % 16;

        return $directions[$index];
    }

    /*
      Convert a timezone offset in seconds to a "UTC+6:00" style label.
     */
    private function timezoneOffsetLabel(int $offsetSeconds): string
    {
        $hours = intdiv(abs($offsetSeconds), 3600);
        $minutes = intdiv(abs($offsetSeconds) % 3600, 60);
        $sign = $offsetSeconds >= 0 ? '+' : '-';

        return sprintf('UTC%s%d:%02d', $sign, $hours, $minutes);
    }
}
