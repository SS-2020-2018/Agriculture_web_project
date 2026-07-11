<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    /*
     @var list<string>
     */
    protected $fillable = [
        'crop_name',
        'crop_image',
        'market_name',
        'price_per_unit',
        'unit',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'price_per_unit' => 'decimal:2',
        ];
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    /*
      Full public URL for the crop image, or null if none was uploaded
      (the view falls back to a generic 🌾 icon in that case).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->crop_image ? asset('storage/'.$this->crop_image) : null;
    }

    /*
      "৳150.00 / kg" style display string.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '৳'.number_format((float) $this->price_per_unit, 2).' / '.$this->unit;
    }
}
