<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    /*
      @var list<string>
     */
    protected $fillable = [
        'user_id',
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_reviewed' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /*
      A farmer may only edit/delete their own feedback before an admin
      has reviewed it — used by FeedbackPolicy and to conditionally show
      the Edit/Delete buttons in the view.
     */
    public function getIsEditableAttribute(): bool
    {
        return ! $this->is_reviewed;
    }
}
