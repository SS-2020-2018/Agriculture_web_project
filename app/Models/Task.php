<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /*
       is_completed is only ever changed through ReminderController::toggle(),
     */
    protected $fillable = [
        'user_id',
        'title',
        'reminder_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'reminder_date' => 'date',
            'is_completed' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
      True when this reminder's date is today.
     */
    public function getIsTodayAttribute(): bool
    {
        return $this->reminder_date->isToday();
    }

    /*
      True when this reminder's date is in the past (and it's not completed yet).
      True when the reminder date has passed and it's still not completed.
     */
    public function getIsOverdueAttribute(): bool
    {
        return ! $this->is_completed
            && $this->reminder_date->isPast()
            && ! $this->reminder_date->isToday();
    }

    /*
    True when this reminder's date is in the past (and it's not completed yet).
    True when the reminder falls within the next 3 days (excluding today)
    and isn't completed yet — used for the "Upcoming" subtle highlight.
     */
    public function getIsUpcomingAttribute(): bool
    {
        return ! $this->is_completed
            && $this->reminder_date->isFuture()
            && $this->reminder_date->diffInDays(now()) <= 3;
    }
}
