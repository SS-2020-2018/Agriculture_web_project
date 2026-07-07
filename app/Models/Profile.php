<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'district',
        'profession',
        'photo',
    ];

    /**
     * A profile belongs to exactly one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: full public URL for the uploaded photo, or null if
     * the farmer hasn't uploaded one yet (views fall back to the
     * default avatar emoji in that case).
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
