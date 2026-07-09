<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\View\View;

class DiseaseAlertController extends Controller
{
    /*
      Display all published disease alerts. 
    */
    public function index(): View
    {
        $diseases = Disease::latest()->get();

        // Distinct crop list, used to populate the "Filter by crop"
        // dropdown without hardcoding crop names anywhere.
        $affectedCrops = $diseases->pluck('affected_crop')->unique()->sort()->values();

        return view('diseases.index', compact('diseases', 'affectedCrops'));
    }

    public function show(Disease $disease): View
    {
        return view('diseases.show', compact('disease'));
    }
}
