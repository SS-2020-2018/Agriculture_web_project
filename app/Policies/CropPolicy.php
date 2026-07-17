<?php

namespace App\Policies;

use App\Models\Crop;
use App\Models\User;

class CropPolicy
{
    /*
     A farmer may view their own crop; an admin may view any crop
     (needed for the Admin Panel's feedback.
     */
    public function view(User $user, Crop $crop): bool
    {
        return $user->id === $crop->user_id || $user->isAdmin();
    }

    /*
    Only the owning farmer can edit their crop's details. Admins
    intentionally cannot — per the spec, admins may only leave
    feedback, never edit or delete a farmer's crop record.
    */
    public function update(User $user, Crop $crop): bool
    {
        return $user->id === $crop->user_id;
    }
    /*
     Only the owning farmer can delete their crop.
    */
    public function delete(User $user, Crop $crop): bool
    {
        return $user->id === $crop->user_id;
    }
}
