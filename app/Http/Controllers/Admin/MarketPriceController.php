<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarketPriceRequest;
use App\Http\Requests\UpdateMarketPriceRequest;
use App\Models\MarketPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MarketPriceController extends Controller
{
    public function index(): View
    {
        $prices = MarketPrice::latest()->get();

        return view('admin.prices.index', compact('prices'));
    }

    public function create(): View
    {
        return view('admin.prices.create');
    }

    public function store(StoreMarketPriceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('crop_image')) {
            $validated['crop_image'] = $request->file('crop_image')->store('price-images', 'public');
        }

        $validated['admin_id'] = $request->user()->id;

        MarketPrice::create($validated);

        return redirect()->route('admin.prices.index')->with('status', 'price-added');
    }

    public function edit(MarketPrice $price): View
    {
        return view('admin.prices.edit', compact('price'));
    }

    public function update(UpdateMarketPriceRequest $request, MarketPrice $price): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('crop_image')) {
            if ($price->crop_image) {
                Storage::disk('public')->delete($price->crop_image);
            }
            $validated['crop_image'] = $request->file('crop_image')->store('price-images', 'public');
        }

        $price->update($validated);

        return redirect()->route('admin.prices.index')->with('status', 'price-updated');
    }

    public function destroy(MarketPrice $price): RedirectResponse
    {
        if ($price->crop_image) {
            Storage::disk('public')->delete($price->crop_image);
        }

        $price->delete();

        return redirect()->route('admin.prices.index')->with('status', 'price-deleted');
    }
}
