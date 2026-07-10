<?php

namespace App\Models;

// Note: Notifiable is used later (Phase 10) for the in-app notification system.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /* @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /*
     The attributes that are mass assignable.
    
     @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /*
     The attributes that should be hidden for serialization.
     
      @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
     Get the attributes that should be cast.
    
     @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
      A user (farmer or admin) has exactly one profile record
      holding phone, address, district, profession, and photo.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /*
      All crops registered by this farmer.
     */
    public function crops()
    {
        return $this->hasMany(Crop::class);
    }

    /*
     All reminders (tasks) created by this farmer.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /*
     Disease alerts this user has published (admin accounts only).
     */
    public function publishedDiseases()
    {
        return $this->hasMany(Disease::class, 'admin_id');
    }

    // Relationships to Question, Feedback, etc. will be added here in
    // their respective phases as those models are created.

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFarmer(): bool
    {
        return $this->role === 'farmer';
    }
}
