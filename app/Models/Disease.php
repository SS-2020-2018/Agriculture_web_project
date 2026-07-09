<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    /*
     Mass assignable attributes. admin_id is set explicitly by the
     controller from the logged-in admin, never from form input.
    
     @var list<string>
     */
    protected $fillable = [
        'name',
        'affected_crop',
        'image',
        'warning_level',
        'symptoms',
        'preventive_measures',
        'suggested_treatments',
        'additional_recommendations',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /*
      Full public URL for the disease image.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    /*
      Human-friendly label for the warning_level enum.
     */
    public function getWarningLabelAttribute(): string
    {
        return ucfirst($this->warning_level);
    }

    /*
     Color keyword matching the spec: green/Low, yellow/Medium,
     orange/High, red/Critical — used to pick the .disease-warning-*
     CSS class.
     */
    public function getWarningColorAttribute(): string
    {
        return match ($this->warning_level) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray',
        };
    }
}
