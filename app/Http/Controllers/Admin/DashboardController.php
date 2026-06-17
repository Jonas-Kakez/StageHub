<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Candidature;
use App\Models\Departement;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\OffreStage;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'etudiants' => Etudiant::count(),
            'entreprises' => Entreprise::where('statut_validation', 'validee')->count(),
            'stages_actifs' => Affectation::where('statut', 'active')->count(),
            'stages_completes' => Affectation::where('statut', 'terminee')->count(),
            'offres_actives' => OffreStage::where('statut', 'active')->count(),
            'candidatures' => Candidature::count(),
        ];

        $stats['taux_placement'] = $stats['etudiants'] > 0
            ? round((Etudiant::whereIn('statut', ['en_stage', 'stage_termine'])->count() / $stats['etudiants']) * 100)
            : 0;

        $recentEntreprises = Entreprise::with('user')->latest()->take(5)->get();
        $recentEtudiants = Etudiant::with('user')->latest()->take(5)->get();

        $chartData = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            'candidatures' => [12, 19, 15, 25, 22, 30],
            'affectations' => [8, 12, 10, 18, 15, 20],
        ];

        return view('admin.dashboard', compact('stats', 'recentEntreprises', 'recentEtudiants', 'chartData'));
    }
}
