<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $etudiant = $request->user()->etudiant;

        $stats = [
            'candidatures' => $etudiant->candidatures()->count(),
            'en_attente' => $etudiant->candidatures()->where('statut', 'en_attente')->count(),
            'acceptees' => $etudiant->candidatures()->where('statut', 'acceptee')->count(),
            'affectations' => $etudiant->affectations()->where('statut', 'active')->count(),
        ];

        return view('etudiant.dashboard', compact('etudiant', 'stats'));
    }
}
