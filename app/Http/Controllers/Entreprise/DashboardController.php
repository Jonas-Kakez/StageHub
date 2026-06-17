<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $entreprise = $request->user()->entreprise;

        if (! $entreprise) {
            abort(403);
        }

        $stats = [
            'offres' => $entreprise->offresStage()->count(),
            'offres_actives' => $entreprise->offresStage()->where('statut', 'active')->count(),
            'candidatures' => \App\Models\Candidature::whereIn(
                'offre_stage_id',
                $entreprise->offresStage()->pluck('id')
            )->count(),
            'stagiaires' => $entreprise->affectations()->where('statut', 'active')->count(),
        ];

        return view('entreprise.dashboard', compact('entreprise', 'stats'));
    }
}
