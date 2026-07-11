<?php

namespace App\Notifications;

use App\Models\Tip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TipLiked extends Notification
{
    use Queueable;

    public function __construct(private readonly Tip $tip)
    {
    }

    /*
     Database-only notification — no email/SMS needed for this one.
     
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
        return [
            'icon' => '💡',
            'title' => $this->tip->title,
            'message' => "You liked the farming tip \"{$this->tip->title}\".",
            'url' => route('tips.show', $this->tip),
        ];
    }
}
