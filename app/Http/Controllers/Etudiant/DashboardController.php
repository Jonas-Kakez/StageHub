<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\OffreStage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $etudiant = $request->user()->etudiant;

        $stats = [
            'candidatures' => $etudiant->candidatures()->count(),
            'en_attente' => $etudiant->candidatures()->whereIn('statut', ['en_attente', 'transmise'])->count(),
            'acceptees' => $etudiant->candidatures()->where('statut', 'acceptee')->count(),
            'affectations' => $etudiant->affectations()->where('statut', 'active')->count(),
        ];

        $offresRecentes = OffreStage::with('entreprise')
            ->where('statut', 'active')
            ->where('moderee', true)
            ->latest('publie_le')
            ->take(12)
            ->get();

        return view('etudiant.dashboard', compact('etudiant', 'stats', 'offresRecentes'));
    }
}
