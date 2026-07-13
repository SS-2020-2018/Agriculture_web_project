<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFertilizerRequest;
use App\Http\Requests\UpdateFertilizerRequest;
use App\Models\Fertilizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FertilizerController extends Controller
{
    public function index(): View
    {
        $fertilizers = Fertilizer::latest()->get();

        return view('admin.fertilizers.index', compact('fertilizers'));
    }

    public function create(): View
    {
        return view('admin.fertilizers.create');
    }

    public function store(StoreFertilizerRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('crop_image')) {
            $validated['crop_image'] = $request->file('crop_image')->store('fertilizer-images', 'public');
        }

        $validated['admin_id'] = $request->user()->id;

        Fertilizer::create($validated);

        return redirect()->route('admin.fertilizers.index')->with('status', 'fertilizer-added');
    }

    public function edit(Fertilizer $fertilizer): View
    {
        return view('admin.fertilizers.edit', compact('fertilizer'));
    }

    public function update(UpdateFertilizerRequest $request, Fertilizer $fertilizer): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('crop_image')) {
            if ($fertilizer->crop_image) {
                Storage::disk('public')->delete($fertilizer->crop_image);
            }
            $validated['crop_image'] = $request->file('crop_image')->store('fertilizer-images', 'public');
        }

        $fertilizer->update($validated);

        return redirect()->route('admin.fertilizers.index')->with('status', 'fertilizer-updated');
    }

    public function destroy(Fertilizer $fertilizer): RedirectResponse
    {
        if ($fertilizer->crop_image) {
            Storage::disk('public')->delete($fertilizer->crop_image);
        }

        $fertilizer->delete();

        return redirect()->route('admin.fertilizers.index')->with('status', 'fertilizer-deleted');
    }
}
