<?php

namespace App\Http\Controllers\Departement;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Encadreur;
use App\Models\Etudiant;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $departement = $user->encadreur?->departement
            ?? Encadreur::where('user_id', $user->id)->first()?->departement;

        $stats = [
            'etudiants' => Etudiant::when($departement, fn ($q) => $q->where('departement_id', $departement->id))->count(),
            'encadreurs' => Encadreur::when($departement, fn ($q) => $q->where('departement_id', $departement->id))->count(),
            'stages_actifs' => Affectation::whereHas('etudiant', function ($q) use ($departement) {
                if ($departement) {
                    $q->where('departement_id', $departement->id);
                }
            })->where('statut', 'active')->count(),
        ];

        return view('departement.dashboard', compact('stats', 'departement'));
    }
}
