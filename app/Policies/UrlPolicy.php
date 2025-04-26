<?php

namespace App\Policies;

use App\Models\Url;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UrlPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given URL can be updated by the user.
     */
    public function update(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }

    /**
     * Determine if the given URL can be deleted by the user.
     */
    public function delete(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }

    /**
     * Determine if the given URL can be viewed by the user.
     */
    public function view(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }
}