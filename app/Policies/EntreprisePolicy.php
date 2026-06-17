<?php

namespace App\Policies;

use App\Models\Entreprise;
use App\Models\User;

class EntreprisePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Entreprise $entreprise): bool
    {
        return $user->isAdmin() || $user->id === $entreprise->user_id;
    }

    public function validate(User $user): bool
    {
        return $user->isAdmin();
    }
}
