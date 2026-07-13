<?php

namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;

class FeedbackPolicy
{
    /*
      A farmer may update their own feedback only while it's still
      unreviewed — once an admin marks it Reviewed, it locks.
     */
    public function update(User $user, Feedback $feedback): bool
    {
        return $user->id === $feedback->user_id && ! $feedback->is_reviewed;
    }

    /*
      Same rule applies to deletion.
     */
    public function delete(User $user, Feedback $feedback): bool
    {
        return $user->id === $feedback->user_id && ! $feedback->is_reviewed;
    }
}
