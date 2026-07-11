<?php

namespace App\Policies;

use App\Models\SavedTip;
use App\Models\User;

class SavedTipPolicy
{
    public function delete(User $user, SavedTip $savedTip): bool
    {
        return $user->id === $savedTip->user_id;
    }
}
