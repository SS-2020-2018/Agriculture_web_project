<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /*
      List every piece of feedback from every farmer. Search/filter/sort
      happen client-side in JS, consistent with the rest of the admin area.
     */
    public function index(): View
    {
        $feedbackEntries = Feedback::with('user.profile')->latest()->get();

        return view('admin.feedback.index', [
            'feedbackEntries' => $feedbackEntries,
            'averageRating' => round($feedbackEntries->avg('rating') ?? 0, 1),
        ]);
    }

    /*
      Mark a piece of feedback as reviewed. This is one-directional by
      design — once reviewed, it also locks the farmer out of editing or
      deleting it (see FeedbackPolicy), so there's no "unreview" action.
     */
    public function markReviewed(Feedback $feedback): RedirectResponse
    {
        $feedback->is_reviewed = true;
        $feedback->save();

        return back()->with('status', 'feedback-reviewed');
    }
}
