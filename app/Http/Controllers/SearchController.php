<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Feedback;
use App\Models\Fertilizer;
use App\Models\MarketPrice;
use App\Models\News;
use App\Models\Question;
use App\Models\SavedTip;
use App\Models\Task;
use App\Models\Tip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /*
     Minimum query length before we bother hitting the database —
     avoids firing 10 queries for every single keystroke on a 1-letter search.
     */
    private const MIN_QUERY_LENGTH = 2;

    /*
      Max results returned per category, to keep the dropdown readable.
     */
    private const PER_CATEGORY_LIMIT = 6;

    /*
      Global search across every module. Each category is scoped exactly
      the same way its own module scopes it elsewhere in the app —
      personal data (Crops, Reminders, Feedback, Saved Tips, Questions)
      only returns the current farmer's own records; shared content
      (Tips, Prices, News, Diseases, Fertilizer Guide) is searched
      app-wide. This mirrors each module's existing authorization rules
      rather than introducing a new set of rules just for search.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));
        $category = $request->query('category', 'all');
        $farmer = $request->user();

        if (mb_strlen($query) < self::MIN_QUERY_LENGTH) {
            return response()->json(['query' => $query, 'total' => 0, 'results' => []]);
        }

        $searchers = [
            'crops' => fn () => $this->searchCrops($query, $farmer->id),
            'tips' => fn () => $this->searchTips($query),
            'saved_tips' => fn () => $this->searchSavedTips($query, $farmer->id),
            'questions' => fn () => $this->searchQuestions($query, $farmer->id),
            'prices' => fn () => $this->searchPrices($query),
            'news' => fn () => $this->searchNews($query),
            'diseases' => fn () => $this->searchDiseases($query),
            'fertilizers' => fn () => $this->searchFertilizers($query),
            'reminders' => fn () => $this->searchReminders($query, $farmer->id),
            'feedback' => fn () => $this->searchFeedback($query, $farmer->id),
        ];

        $results = [];

        foreach ($searchers as $key => $searcher) {
            if ($category !== 'all' && $category !== $key) {
                continue;
            }

            $items = $searcher();

            if (! empty($items)) {
                $results[$key] = $items;
            }
        }

        $total = array_sum(array_map('count', $results));

        return response()->json([
            'query' => $query,
            'total' => $total,
            'results' => $results,
        ]);
    }

    private function searchCrops(string $query, int $farmerId): array
    {
        return Crop::where('user_id', $farmerId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%");
            })
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->name,
                description: $item->description,
                url: route('crops.show', $item),
                icon: '🌱',
                categoryLabel: 'Crops',
                date: $item->created_at,
            ))->all();
    }

    private function searchTips(string $query): array
    {
        return Tip::where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%");
        })
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->title,
                description: $item->description,
                url: route('tips.show', $item),
                icon: '💡',
                categoryLabel: 'Farming Tips',
                date: $item->created_at,
            ))->all();
    }

    private function searchSavedTips(string $query, int $farmerId): array
    {
        return SavedTip::where('user_id', $farmerId)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%");
            })
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->title,
                description: $item->description,
                url: route('saved-tips.index'),
                icon: '🔖',
                categoryLabel: 'Saved Tips',
                date: $item->created_at,
            ))->all();
    }

    private function searchQuestions(string $query, int $farmerId): array
    {
        return Question::where('user_id', $farmerId)
            ->where('question_text', 'like', "%{$query}%")
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: Str::limit($item->question_text, 60),
                description: $item->status === 'answered' ? 'Answered' : 'Pending reply',
                url: route('qa.index').'#question-'.$item->id,
                icon: '❓',
                categoryLabel: 'Question & Answer',
                date: $item->created_at,
            ))->all();
    }

    private function searchPrices(string $query): array
    {
        return MarketPrice::where('crop_name', 'like', "%{$query}%")
            ->orWhere('market_name', 'like', "%{$query}%")
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->crop_name,
                description: $item->formatted_price.' at '.$item->market_name,
                url: route('prices.show', $item),
                icon: '💰',
                categoryLabel: 'Crop Prices',
                date: $item->updated_at,
            ))->all();
    }

    private function searchNews(string $query): array
    {
        return News::where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%");
        })
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->title,
                description: $item->description,
                url: route('news.show', $item),
                icon: '📰',
                categoryLabel: 'Agriculture News',
                date: $item->created_at,
            ))->all();
    }

    private function searchDiseases(string $query): array
    {
        return Disease::where('name', 'like', "%{$query}%")
            ->orWhere('affected_crop', 'like', "%{$query}%")
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->name,
                description: 'Affects: '.$item->affected_crop,
                url: route('diseases.show', $item),
                icon: '🚨',
                categoryLabel: 'Disease Alerts',
                date: $item->created_at,
            ))->all();
    }

    private function searchFertilizers(string $query): array
    {
        return Fertilizer::where('crop_name', 'like', "%{$query}%")
            ->orWhere('fertilizers', 'like', "%{$query}%")
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->crop_name,
                description: $item->fertilizers,
                url: route('fertilizer.show', $item),
                icon: '🧪',
                categoryLabel: 'Fertilizer Guide',
                date: $item->updated_at,
            ))->all();
    }

    private function searchReminders(string $query, int $farmerId): array
    {
        return Task::where('user_id', $farmerId)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")->orWhere('notes', 'like', "%{$query}%");
            })
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: $item->title,
                description: $item->is_completed ? 'Completed' : 'Pending',
                url: route('reminders.index').'#reminder-'.$item->id,
                icon: '📅',
                categoryLabel: 'Reminders',
                date: $item->reminder_date,
            ))->all();
    }

    private function searchFeedback(string $query, int $farmerId): array
    {
        return Feedback::where('user_id', $farmerId)
            ->where('comment', 'like', "%{$query}%")
            ->latest()
            ->limit(self::PER_CATEGORY_LIMIT)
            ->get()
            ->map(fn ($item) => $this->formatResult(
                title: str_repeat('⭐', $item->rating).' rating',
                description: $item->comment,
                url: route('feedback.index'),
                icon: '⭐',
                categoryLabel: 'Feedback',
                date: $item->created_at,
            ))->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function formatResult(string $title, ?string $description, string $url, string $icon, string $categoryLabel, $date): array
    {
        return [
            'title' => $title,
            'description' => Str::limit((string) $description, 90),
            'url' => $url,
            'icon' => $icon,
            'category_label' => $categoryLabel,
            'date' => $date?->format('d M, Y'),
            'timestamp' => $date?->timestamp,
        ];
    }
}
