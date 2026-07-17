<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipRequest;
use App\Http\Requests\UpdateTipRequest;
use App\Models\Tip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TipController extends Controller
{
    public function index(): View
    {
        $tips = Tip::withCount('likers')->latest()->get();

        return view('admin.tips.index', [
            'tips' => $tips,
            'totalLikes' => $tips->sum('likers_count'),
        ]);
    }

    public function create(): View
    {
        return view('admin.tips.create');
    }

    public function store(StoreTipRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['image'] = $request->file('image')->store('tip-images', 'public');
        $validated['admin_id'] = $request->user()->id;

        Tip::create($validated);

        return redirect()->route('admin.tips.index')->with('status', 'tip-added');
    }

    public function edit(Tip $tip): View
    {
        return view('admin.tips.edit', compact('tip'));
    }

    public function update(UpdateTipRequest $request, Tip $tip): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($tip->image);
            $validated['image'] = $request->file('image')->store('tip-images', 'public');
        }

        $tip->update($validated);

        return redirect()->route('admin.tips.index')->with('status', 'tip-updated');
    }

    public function destroy(Tip $tip): RedirectResponse
    {
        Storage::disk('public')->delete($tip->image);
        $tip->delete();

        return redirect()->route('admin.tips.index')->with('status', 'tip-deleted');
    }

    /*
     Returns the list of farmers who liked this tip, for the "click the
     like count" popup in the admin table. Loaded via fetch() rather
     than server-rendered per tip
     */
    public function likers(Tip $tip): JsonResponse
    {
        $likers = $tip->likers()
            ->with('profile')
            ->get()
            ->map(fn ($farmer) => [
                'id' => $farmer->id,
                'name' => $farmer->name,
                'address' => $farmer->profile->address ?? 'Not provided',
                'photo_url' => ($farmer->profile && $farmer->profile->photo)
                    ? asset('storage/'.$farmer->profile->photo)
                    : null,
            ]);

        return response()->json(['likers' => $likers]);
    }
}
