<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    /*
      @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'image',
        'planting_date',
        'expected_harvest_date',
        'land_area',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'planting_date' => 'date',
            'expected_harvest_date' => 'date',
            'admin_feedback_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     Only crops registered within the last 7 days — powers the
     "Recently Added" summary stat on the Crop Management page.
     */
    public function scopeRecentlyAdded(Builder $query): Builder
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /*
     Human-friendly label for the status enum, used throughout the views
     instead of repeating match/switch statements in Blade.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'growing' => 'Growing',
            'ready_for_harvest' => 'Ready for Harvest',
            'harvested' => 'Harvested',
            default => ucfirst($this->status),
        };
    }

    /*
     Color keyword used to pick the matching .crop-status-* CSS class.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'growing' => 'green',
            'ready_for_harvest' => 'orange',
            'harvested' => 'gray',
            default => 'gray',
        };
    }

    /*
     Full public URL for the crop image.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
