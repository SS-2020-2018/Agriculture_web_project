<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

class NewsController extends Controller
{
    /*
      Display all published news articles. Search/filter/sort happen
      client-side in JS, consistent with Disease Alerts and Crop Prices.
     */
    public function index(): View
    {
        $articles = News::latest()->get();

        return view('news.index', compact('articles'));
    }

    public function show(News $news): View
    {
        $news->load('admin');

        return view('news.show', compact('news'));
    }
}
