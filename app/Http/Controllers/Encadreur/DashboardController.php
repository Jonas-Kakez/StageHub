<?php

namespace App\Http\Controllers\Encadreur;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $encadreur = $request->user()->encadreur;

        $stats = [
            'stagiaires' => $encadreur->affectations()->where('statut', 'active')->count(),
            'rapports' => \App\Models\RapportStage::whereIn(
                'affectation_id',
                $encadreur->affectations()->pluck('id')
            )->count(),
            'evaluations' => $encadreur->evaluations()->count(),
        ];

        return view('encadreur.dashboard', compact('encadreur', 'stats'));
    }
}
