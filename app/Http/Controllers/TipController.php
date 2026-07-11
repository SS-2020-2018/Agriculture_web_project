<?php

namespace App\Http\Controllers;

use App\Models\SavedTip;
use App\Models\Tip;
use App\Notifications\TipLiked;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TipController extends Controller
{
    /*
      Display the Farming Tips page: today's featured tip (the most
      recently published one) followed by every other tip as a card.
     */
    public function index(Request $request): View
    {
        $farmer = $request->user();

        $tips = Tip::withCount('likers')->latest()->get();
        $featuredTip = $tips->first();

        return view('tips.index', [
            'featuredTip' => $featuredTip,
            'tips' => $tips,
            'likedTipIds' => $farmer->likedTips()->pluck('tips.id')->all(),
            'savedTipIds' => SavedTip::where('user_id', $farmer->id)->pluck('original_tip_id')->all(),
        ]);
    }

    /*
      Full detail page for a single tip ("Read More").
     */
    public function show(Request $request, Tip $tip): View
    {
        $farmer = $request->user();
        $tip->loadCount('likers');

        return view('tips.show', [
            'tip' => $tip,
            'isLiked' => $tip->likers()->where('user_id', $farmer->id)->exists(),
            'isSaved' => SavedTip::where('user_id', $farmer->id)->where('original_tip_id', $tip->id)->exists(),
        ]);
    }

    /*
     Toggle like/unlike via fetch() — updates the count instantly with
     no page reload, and fires a confirmation notification on like
     (not on unlike, per the spec's wording).
     */
    public function toggleLike(Request $request, Tip $tip): JsonResponse
    {
        $farmer = $request->user();
        $alreadyLiked = $tip->likers()->where('user_id', $farmer->id)->exists();

        if ($alreadyLiked) {
            $tip->likers()->detach($farmer->id);
            $liked = false;
        } else {
            $tip->likers()->attach($farmer->id);
            $liked = true;
            $farmer->notify(new TipLiked($tip));
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $tip->likers()->count(),
        ]);
    }
}
