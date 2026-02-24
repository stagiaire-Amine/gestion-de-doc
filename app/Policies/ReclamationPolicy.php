<?php

namespace App\Policies;

use App\Models\Reclamation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReclamationPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->is_admin) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Reclamation $reclamation): bool
    {
        return $user->id === $reclamation->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Reclamation $reclamation): bool
    {
        return $user->id === $reclamation->user_id;
    }

    public function delete(User $user, Reclamation $reclamation): bool
    {
        return $user->id === $reclamation->user_id;
    }

    public function restore(User $user, Reclamation $reclamation): bool
    {
        return $user->id === $reclamation->user_id;
    }

    public function forceDelete(User $user, Reclamation $reclamation): bool
    {
        return $user->id === $reclamation->user_id;
    }
}
