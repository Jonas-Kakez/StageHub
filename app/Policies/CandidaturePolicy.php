<?php

namespace App\Policies;

use App\Models\Candidature;
use App\Models\User;

class CandidaturePolicy
{
    public function view(User $user, Candidature $candidature): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEtudiant()) {
            return $candidature->etudiant->user_id === $user->id;
        }

        if ($user->isEntreprise()) {
            return $candidature->offreStage->entreprise->user_id === $user->id;
        }

        return false;
    }

    public function update(User $user, Candidature $candidature): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEntreprise()) {
            return $candidature->offreStage->entreprise->user_id === $user->id;
        }

        return false;
    }
}
