<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;
use App\Models\Disease;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DiseaseController extends Controller
{
    /*
     List every published disease for admin management.
     */
    public function index(): View
    {
        $diseases = Disease::latest()->get();

        return view('admin.diseases.index', compact('diseases'));
    }

    public function create(): View
    {
        return view('admin.diseases.create');
    }

    public function store(StoreDiseaseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['image'] = $request->file('image')->store('disease-images', 'public');
        $validated['admin_id'] = $request->user()->id;

        Disease::create($validated);

        return redirect()->route('admin.diseases.index')->with('status', 'disease-added');
    }

    public function edit(Disease $disease): View
    {
        return view('admin.diseases.edit', compact('disease'));
    }

    public function update(UpdateDiseaseRequest $request, Disease $disease): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($disease->image);
            $validated['image'] = $request->file('image')->store('disease-images', 'public');
        }

        $disease->update($validated);

        return redirect()->route('admin.diseases.index')->with('status', 'disease-updated');
    }

    public function destroy(Disease $disease): RedirectResponse
    {
        Storage::disk('public')->delete($disease->image);
        $disease->delete();

        return redirect()->route('admin.diseases.index')->with('status', 'disease-deleted');
    }
}
