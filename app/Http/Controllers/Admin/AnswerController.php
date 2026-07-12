<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnswerRequest;
use App\Models\Question;
use App\Notifications\QuestionAnswered;
use Illuminate\Http\RedirectResponse;

class AnswerController extends Controller
{
    /*
      Post a reply to a farmer's question. Marks the question as
      answered and notifies the farmer — this is the notification
      system from Phase 8 firing on someone ELSE's action for the
      first time (the admin's reply notifies the farmer, not themself).
     */
    public function store(StoreAnswerRequest $request, Question $question): RedirectResponse
    {
        $answer = $question->answers()->create([
            'admin_id' => $request->user()->id,
            'answer_text' => $request->validated('answer_text'),
        ]);

       $question->status = 'answered';
       $question->save();

        $question->farmer->notify(new QuestionAnswered($question));

        return redirect()->route('admin.qa.show', $question)->with('status', 'answer-posted');
    }
}
