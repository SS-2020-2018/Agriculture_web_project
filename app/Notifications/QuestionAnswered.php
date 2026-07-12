<?php

namespace App\Notifications;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class QuestionAnswered extends Notification
{
    use Queueable;

    public function __construct(private readonly Question $question)
    {
    }

    /*
      @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /*
      @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $preview = Str::limit($this->question->question_text, 60);

        return [
            'icon' => '💬',
            'title' => $preview,
            'message' => "An admin answered your question: \"{$preview}\"",
            'url' => route('qa.index').'#question-'.$this->question->id,
        ];
    }
}
