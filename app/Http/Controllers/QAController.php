<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QAController extends Controller
{
    /*
      Display the farmer's Question & Answer page: the submission form
      plus every question they've asked, each with its answer(s) shown
      inline as a conversation thread — no separate "view discussion"
      page needed, everything lives on this one page.
     */
    public function index(Request $request): View
    {
        $farmer = $request->user();

        $questions = Question::with('answers.admin')
            ->where('user_id', $farmer->id)
            ->latest()
            ->get();

        return view('qa.index', [
            'questions' => $questions,
            'likedAnswerIds' => $farmer->likedAnswers()->pluck('answers.id')->all(),
        ]);
    }

    /*
      Submit a new question.
     */
    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('question-images', 'public');
        }
        $validated['user_id'] = $request->user()->id;
        Question::create($validated);
        return redirect()->route('qa.index')->with('status', 'question-submitted');
    }

    /*
      Toggle like/unlike on an answer via fetch() — instant, no reload.
     */
    public function toggleAnswerLike(Request $request, Answer $answer): JsonResponse
    {
        $farmer = $request->user();
        $alreadyLiked = $answer->likers()->where('user_id', $farmer->id)->exists();

        if ($alreadyLiked) {
            $answer->likers()->detach($farmer->id);
            $liked = false;
        } else {
            $answer->likers()->attach($farmer->id);
            $liked = true;
        }
        return response()->json([
            'liked' => $liked,
            'likes_count' => $answer->likers()->count(),
        ]);
    }
}
