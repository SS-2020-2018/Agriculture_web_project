<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /*
      "News" is a famously irregular English plural/singular, so rather
      than trust Eloquent's pluralizer to guess the table name correctly,
      we spell it out explicitly (same lesson learned from the
      SavedTip/save_tips mismatch back in Phase 8).
     */
    protected $table = 'news';

    /*
      @var list<string>
     */
    protected $fillable = [
        'title',
        'category',
        'image',
        'description',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/'.$this->image);
    }

    /*
      Human-friendly label for the category enum.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'rain_alert' => 'Rain Alert',
            'government_notice' => 'Government Notice',
            'disease_pest_alert' => 'Disease & Pest Alert',
            'new_farming_method' => 'New Farming Method',
            default => ucfirst(str_replace('_', ' ', $this->category)),
        };
    }

    /*
      Icon matching the category, used on cards and the detail page.
     */
    public function getCategoryIconAttribute(): string
    {
        return match ($this->category) {
            'rain_alert' => '🌧️',
            'government_notice' => '🏛️',
            'disease_pest_alert' => '🐛',
            'new_farming_method' => '🌱',
            default => '📰',
        };
    }
}
