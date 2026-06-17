<?php

namespace App\Policies;

use App\Models\OffreStage;
use App\Models\User;

class OffreStagePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isEntreprise() && $user->entreprise?->isValidee();
    }

    public function update(User $user, OffreStage $offre): bool
    {
        return $user->isAdmin() || $offre->entreprise->user_id === $user->id;
    }

    public function moderate(User $user): bool
    {
        return $user->isAdmin();
    }
}
