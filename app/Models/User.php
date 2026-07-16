<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /* @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /*
      The attributes that are mass assignable. Note: account_status is
      deliberately NOT here — it's only ever changed by an admin via
      Admin\FarmerController::toggleStatus(), using direct property
      assignment (same pattern as Task::is_completed, Question::status,
      and Feedback::is_reviewed elsewhere in this app).
     
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

    /*
      Farming tips this user has published (admin accounts only).
     */
    public function publishedTips()
    {
        return $this->hasMany(Tip::class, 'admin_id');
    }

    /*
      Market price records this user has published (admin accounts only).
     */
    public function publishedMarketPrices()
    {
        return $this->hasMany(MarketPrice::class, 'admin_id');
    }

    /*
      News articles this user has published (admin accounts only).
     */
    public function publishedNews()
    {
        return $this->hasMany(News::class, 'admin_id');
    }

    /*
      Fertilizer guides this user has published (admin accounts only).
     */
    public function publishedFertilizerGuides()
    {
        return $this->hasMany(Fertilizer::class, 'admin_id');
    }

    /*
      Tips this farmer has liked.
     */
    public function likedTips()
    {
        return $this->belongsToMany(Tip::class, 'tip_likes')->withTimestamps();
    }

    /*
     Tips this farmer has saved for later (independent snapshots).
     */
    public function savedTips()
    {
        return $this->hasMany(SavedTip::class);
    }

    /*
      Questions this farmer has asked.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /*
      Answers this farmer has liked.
     */
    public function likedAnswers()
    {
        return $this->belongsToMany(Answer::class, 'answer_likes')->withTimestamps();
    }

    /*
      Feedback this farmer has submitted.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFarmer(): bool
    {
        return $this->role === 'farmer';
    }

    /*
     Suspended farmers are blocked at login — see LoginRequest::authenticate().
     */
    public function isSuspended(): bool
    {
        return $this->account_status === 'suspended';
    }
}
