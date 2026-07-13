<?php

namespace App\Http\Controllers;

use App\Models\Fertilizer;
use Illuminate\View\View;

class FertilizerController extends Controller
{
    /*
      Display all fertilizer guides. Search (with a datalist of known
      crop names for autocomplete-style suggestions) happens client-side
      in JS, consistent with the rest of the app.
     */
    public function index(): View
    {
        $fertilizers = Fertilizer::latest()->get();

        $cropNames = $fertilizers->pluck('crop_name')->unique()->sort()->values();

        return view('fertilizer.index', compact('fertilizers', 'cropNames'));
    }

    public function show(Fertilizer $fertilizer): View
    {
        return view('fertilizer.show', compact('fertilizer'));
    }
}
