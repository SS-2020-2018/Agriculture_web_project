<?php

namespace App\Http\Controllers;

use App\Models\SavedTip;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;

class SavedTipController extends Controller
{
    /*
      Display every tip this farmer has saved.
     */
    public function index(Request $request): View
    {
        $savedTips = SavedTip::where('user_id', $request->user()->id)->latest()->get();

        return view('saved-tips.index', compact('savedTips'));
    }

    /*
     Save a tip. This makes a full, independent COPY of the tip's data
     — including physically copying the image file — so the saved
     version keeps working even if an admin later deletes the original.
     */
    public function store(Request $request, Tip $tip): RedirectResponse
    {
        $farmer = $request->user();

        $alreadySaved = SavedTip::where('user_id', $farmer->id)
            ->where('original_tip_id', $tip->id)
            ->exists();

        if ($alreadySaved) {
            return back()->with('status', 'tip-already-saved');
        }

        $copiedImagePath = null;

        if ($tip->image && Storage::disk('public')->exists($tip->image)) {
            $copiedImagePath = 'saved-tip-images/'.Str::uuid().'_'.basename($tip->image);
            Storage::disk('public')->copy($tip->image, $copiedImagePath);
        }

        SavedTip::create([
            'user_id' => $farmer->id,
            'original_tip_id' => $tip->id,
            'title' => $tip->title,
            'image' => $copiedImagePath,
            'description' => $tip->description,
        ]);

        return back()->with('status', 'tip-saved');
    }

    /*
     Remove a tip from this farmer's personal saved collection. This
     only ever affects their own saved copy — never the original tip.
     */
    public function destroy(SavedTip $savedTip): RedirectResponse
    {
        Gate::authorize('delete', $savedTip);

        if ($savedTip->image) {
            Storage::disk('public')->delete($savedTip->image);
        }

        $savedTip->delete();

        return back()->with('status', 'tip-unsaved');
    }
}
