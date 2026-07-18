<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(Request $request): View
    {
        $feedbackEntries = Feedback::where('user_id', $request->user()->id)
            ->latest()
            ->get();
        return view('feedback.index', compact('feedbackEntries'));
    }

    public function store(StoreFeedbackRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        Feedback::create($validated);

        return redirect()->route('feedback.index')->with('status', 'feedback-submitted');
    }
    /*
      Update a farmer's own feedback — only reachable while it's still
      unreviewed (enforced via FeedbackPolicy).
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback): RedirectResponse
    {
        Gate::authorize('update', $feedback);

        $feedback->update($request->validated());
        
        return redirect()->route('feedback.index')->with('status', 'feedback-updated');
    }

    public function destroy(Feedback $feedback): RedirectResponse
    {
        Gate::authorize('delete', $feedback);

        $feedback->delete();

        return redirect()->route('feedback.index')->with('status', 'feedback-deleted');
    }
}
