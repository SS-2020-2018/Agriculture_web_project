<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'admin_id',
        'answer_text',
    ];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    /*
      Farmers who have liked this answer.
     */
    public function likers()
    {
        return $this->belongsToMany(User::class, 'answer_likes')->withTimestamps();
    }
}
