<?php

namespace App\Http\Controllers;

use App\Models\MarketPrice;
use Illuminate\View\View;

class MarketPriceController extends Controller
{
    /**
     * Display all crop prices. Search/filter/sort happen client-side in
     * JS, consistent with how Disease Alerts and Reminders do it.
     */
    public function index(): View
    {
        $prices = MarketPrice::latest()->get();

        $markets = $prices->pluck('market_name')->unique()->sort()->values();

        return view('prices.index', compact('prices', 'markets'));
    }

    /**
     * Detail page for a single price record, plus a short history of
     * other price entries for the same crop (by name, case-insensitive)
     * so farmers can see how it's trended across markets/dates.
     */
    public function show(MarketPrice $price): View
    {
        $previousPrices = MarketPrice::whereRaw('LOWER(crop_name) = ?', [strtolower($price->crop_name)])
            ->where('id', '!=', $price->id)
            ->latest()
            ->take(5)
            ->get();

        return view('prices.show', compact('price', 'previousPrices'));
    }
}
