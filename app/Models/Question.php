<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /*
      @var list<string>
     */
    protected $fillable = [
        'user_id',
        'question_text',
        'image',
    ];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('created_at');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function getIsAnsweredAttribute(): bool
    {
        return $this->status === 'answered';
    }
}
