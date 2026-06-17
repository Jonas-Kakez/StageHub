<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Candidature;
use App\Models\Evaluation;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StagiaireController extends Controller
{
    public function index(Request $request)
    {
        $entreprise = $request->user()->entreprise;
        $stagiaires = $entreprise->affectations()
            ->with(['etudiant.user', 'offreStage', 'encadreur.user'])
            ->where('statut', 'active')
            ->get();

        return view('entreprise.stagiaires.index', compact('stagiaires', 'entreprise'));
    }

    public function affecter(Request $request, Candidature $candidature)
    {
        $entreprise = $request->user()->entreprise;

        if ($candidature->statut !== 'acceptee' || $candidature->offreStage->entreprise_id !== $entreprise->id) {
            abort(403);
        }

        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        DB::transaction(function () use ($candidature, $entreprise, $validated) {
            Affectation::create([
                'candidature_id' => $candidature->id,
                'etudiant_id' => $candidature->etudiant_id,
                'entreprise_id' => $entreprise->id,
                'offre_stage_id' => $candidature->offre_stage_id,
                'date_debut' => $validated['date_debut'],
                'date_fin' => $validated['date_fin'],
                'statut' => 'active',
            ]);

            $candidature->etudiant->update(['statut' => 'en_stage']);

            NotificationService::send(
                $candidature->etudiant->user,
                'affectation',
                'Stage affecté',
                "Vous avez été affecté au stage « {$candidature->offreStage->titre} ».",
                route('etudiant.candidatures.index')
            );
        });

        return back()->with('success', 'Stagiaire affecté avec succès.');
    }

    public function evaluer(Request $request, Affectation $affectation)
    {
        $entreprise = $request->user()->entreprise;

        if ($affectation->entreprise_id !== $entreprise->id) {
            abort(403);
        }

        $validated = $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        Evaluation::updateOrCreate(
            [
                'affectation_id' => $affectation->id,
                'type' => 'entreprise',
            ],
            [
                'evaluateur_user_id' => $request->user()->id,
                'note' => $validated['note'],
                'commentaire' => $validated['commentaire'],
            ]
        );

        NotificationService::send(
            $affectation->etudiant->user,
            'evaluation',
            'Évaluation reçue',
            'Vous avez reçu une évaluation de votre entreprise.',
            route('etudiant.dashboard')
        );

        return back()->with('success', 'Évaluation enregistrée.');
    }
}
