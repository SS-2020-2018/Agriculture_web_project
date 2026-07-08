<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCropRequest;
use App\Http\Requests\UpdateCropRequest;
use App\Models\Crop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CropController extends Controller
{
    public function index(Request $request): View
    {
        $farmer = $request->user();

        $crops = Crop::where('user_id', $farmer->id)
            ->latest()
            ->get();

        $stats = [
            'total' => $crops->count(),
            'growing' => $crops->where('status', 'growing')->count(),
            'ready' => $crops->where('status', 'ready_for_harvest')->count(),
            'recent' => $crops->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('crops.index', compact('crops', 'stats'));
    }

    /*
      Show the Add Crop form.
     */
    public function create(): View
    {
        return view('crops.create');
    }

    /*
      Store a newly registered crop for the authenticated farmer.
     */
    public function store(StoreCropRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['image'] = $request->file('image')->store('crop-images', 'public');
        $validated['user_id'] = $request->user()->id;

        Crop::create($validated);

        return redirect()->route('crops.index')->with('status', 'crop-added');
    }

    /*
      Show the full details for a single crop.
     */
    public function show(Crop $crop): View
    {
        Gate::authorize('view', $crop);

        return view('crops.show', compact('crop'));
    }

    /*
     Show the Edit Crop form, pre-filled with existing data.
     */
    public function edit(Crop $crop): View
    {
        Gate::authorize('update', $crop);

        return view('crops.edit', compact('crop'));
    }

    /*
     Update an existing crop, optionally replacing its image.
     */
    public function update(UpdateCropRequest $request, Crop $crop): RedirectResponse
    {
        Gate::authorize('update', $crop);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Replace the old image on disk so we don't accumulate orphans.
            Storage::disk('public')->delete($crop->image);
            $validated['image'] = $request->file('image')->store('crop-images', 'public');
        }

        $crop->update($validated);

        return redirect()->route('crops.show', $crop)->with('status', 'crop-updated');
    }

    /*
     Permanently delete a crop and its uploaded image.
     */
    public function destroy(Crop $crop): RedirectResponse
    {
        Gate::authorize('delete', $crop);

        Storage::disk('public')->delete($crop->image);
        $crop->delete();

        return redirect()->route('crops.index')->with('status', 'crop-deleted');
    }
}
