<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedTip extends Model
{
    /*
      @var list<string>
     */
    protected $fillable = [
        'user_id',
        'original_tip_id',
        'title',
        'image',
        'description',
    ];
    protected $table = 'save_tips';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}
