<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $articles = News::latest()->get();

        return view('admin.news.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['image'] = $request->file('image')->store('news-images', 'public');
        $validated['admin_id'] = $request->user()->id;

        News::create($validated);

        return redirect()->route('admin.news.index')->with('status', 'news-added');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($news->image);
            $validated['image'] = $request->file('image')->store('news-images', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('status', 'news-updated');
    }

    public function destroy(News $news): RedirectResponse
    {
        Storage::disk('public')->delete($news->image);
        $news->delete();

        return redirect()->route('admin.news.index')->with('status', 'news-deleted');
    }
}
