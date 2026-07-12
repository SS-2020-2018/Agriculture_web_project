<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\View\View;

class QuestionController extends Controller
{
    /*
      List every question submitted by any farmer, most recent first.
      Pending/Answered filtering happens client-side in JS.
     */
    public function index(): View
    {
        $questions = Question::with('farmer.profile')->latest()->get();

        return view('admin.qa.index', compact('questions'));
    }

    /*
      Full conversation page: the question, any existing answers, and
      the reply form.
     */
    public function show(Question $question): View
    {
        $question->load('farmer.profile', 'answers.admin');

        return view('admin.qa.show', compact('question'));
    }
}
