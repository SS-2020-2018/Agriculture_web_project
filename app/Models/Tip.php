<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'image',
        'description',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Farmers who have liked this tip.
     */
    public function likers()
    {
        return $this->belongsToMany(User::class, 'tip_likes')->withTimestamps();
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/'.$this->image);
    }
}
