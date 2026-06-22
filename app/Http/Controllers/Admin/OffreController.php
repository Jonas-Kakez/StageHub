<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Evaluation;
use App\Models\OffreStage;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $offres = OffreStage::with('entreprise')
            ->when($request->statut, fn ($q, $s) => $q->where('statut', $s))
            ->latest()
            ->paginate(10);

        return view('admin.offres.index', compact('offres'));
    }

    public function create()
    {
        $entreprises = Entreprise::where('statut_validation', 'validee')->orderBy('nom')->get();

        return view('admin.offres.create', compact('entreprises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entreprise_id' => 'required|exists:entreprises,id',
            'titre' => 'required|string|max:255',
            'departement_entreprise' => 'nullable|string|max:255',
            'duree' => 'nullable|string|max:100',
            'localisation' => 'nullable|string|max:255',
            'type_stage' => 'nullable|string|max:255',
            'domaine' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'competences_requises' => 'nullable|string',
            'quota_stagiaires' => 'required|integer|min:1|max:50',
        ]);

        $offre = OffreStage::create([
            ...$validated,
            'statut' => 'active',
            'moderee' => true,
            'publiee_par_institution' => true,
            'publie_le' => now(),
        ]);

        $etudiants = User::where('role', User::ROLE_ETUDIANT)->get();
        foreach ($etudiants as $etu) {
            NotificationService::send(
                $etu,
                'nouvelle_offre',
                'Nouvelle offre de stage UDBL',
                "Une nouvelle offre « {$offre->titre} » est disponible sur la plateforme.",
                route('etudiant.offres.show', $offre)
            );
        }

        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre publiée par le Bureau de stage UDBL.');
    }

    public function approuver(OffreStage $offre)
    {
        $offre->update([
            'statut' => 'active',
            'moderee' => true,
            'publie_le' => now(),
        ]);

        NotificationService::send(
            $offre->entreprise->user,
            'offre_approuvee',
            'Offre approuvée',
            "Votre offre « {$offre->titre} » a été publiée par l'UDBL.",
            route('entreprise.offres.index')
        );

        $etudiants = User::where('role', User::ROLE_ETUDIANT)->get();
        foreach ($etudiants as $etu) {
            NotificationService::send(
                $etu,
                'nouvelle_offre',
                'Nouvelle offre de stage',
                "L'offre « {$offre->titre} » est maintenant disponible.",
                route('etudiant.offres.show', $offre)
            );
        }

        return back()->with('success', 'Offre approuvée et publiée.');
    }

    public function refuser(Request $request, OffreStage $offre)
    {
        $request->validate(['motif_refus' => 'required|string|max:500']);

        $offre->update([
            'statut' => 'refusee',
            'motif_refus' => $request->motif_refus,
        ]);

        NotificationService::send(
            $offre->entreprise->user,
            'offre_refusee',
            'Offre refusée',
            "Votre offre « {$offre->titre} » a été refusée par l'UDBL.",
            route('entreprise.offres.index')
        );

        return back()->with('success', 'Offre refusée.');
    }

    public function desactiver(OffreStage $offre)
    {
        $offre->update(['statut' => 'inactive']);

        return back()->with('success', 'Offre désactivée.');
    }
}
