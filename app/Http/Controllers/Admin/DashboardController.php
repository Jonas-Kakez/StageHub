<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Candidature;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\OffreStage;
use App\Models\RapportStage;
use App\Models\Traitement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'candidatures_en_attente' => Candidature::where('statut', 'en_attente')->count(),
        ];

        $stats['taux_placement'] = $stats['etudiants'] > 0
            ? round((Etudiant::whereIn('statut', ['en_stage', 'stage_termine'])->count() / $stats['etudiants']) * 100)
            : 0;

        $statsParEntreprise = Affectation::select('entreprise_id', DB::raw('count(*) as total'))
            ->where('statut', 'active')
            ->groupBy('entreprise_id')
            ->get()
            ->map(fn ($row) => ['entreprise' => Entreprise::find($row->entreprise_id), 'total' => $row->total]);

        $offresPlusSollicitees = OffreStage::withCount('candidatures')
            ->orderByDesc('candidatures_count')
            ->take(5)
            ->get();

        $domainesPlusDemandes = OffreStage::select('domaine', DB::raw('count(*) as total'))
            ->whereNotNull('domaine')
            ->groupBy('domaine')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $historiqueActions = Traitement::with(['candidature.etudiant.user', 'user'])
            ->latest()
            ->take(10)
            ->get();

        $chartData = [
            'labels' => $domainesPlusDemandes->pluck('domaine')->toArray(),
            'candidatures' => $domainesPlusDemandes->pluck('total')->toArray(),
        ];

        if (empty($chartData['labels'])) {
            $chartData = [
                'labels' => ['Informatique', 'Marketing', 'Finance', 'RH', 'Communication', 'Gestion'],
                'candidatures' => [12, 8, 6, 4, 7, 5],
            ];
        }

        return view('admin.dashboard', compact(
            'stats',
            'statsParEntreprise',
            'offresPlusSollicitees',
            'domainesPlusDemandes',
            'historiqueActions',
            'chartData'
        ));
    }
}
