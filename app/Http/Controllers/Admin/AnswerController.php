<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnswerRequest;
use App\Models\Question;
use App\Notifications\QuestionAnswered;
use Illuminate\Http\RedirectResponse;

class AnswerController extends Controller
{
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
