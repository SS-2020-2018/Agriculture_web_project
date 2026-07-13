<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fertilizer extends Model
{
    /*
      "Fertilizer" pluralizes normally (fertilizers), so Eloquent would
      guess this table name correctly on its own — set explicitly anyway
      for consistency with News/Feedback/SavedTip, and so nobody has to
      wonder later.
     */
    protected $table = 'fertilizers';

    /*
      @var list<string>
     */
    protected $fillable = [
        'crop_name',
        'crop_image',
        'fertilizers',
        'application_stage',
        'quantity',
        'application_method',
        'usage_instructions',
        'additional_notes',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->crop_image ? asset('storage/'.$this->crop_image) : null;
    }

    /*
      Splits the comma-separated `fertilizers` field into a clean array
      for rendering as individual chips/badges, e.g.
      "Urea, TSP, DAP" -> ['Urea', 'TSP', 'DAP'].
      
       @return array<int, string>
      */
    public function getFertilizersListAttribute(): array
    {
        return collect(explode(',', $this->fertilizers))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
