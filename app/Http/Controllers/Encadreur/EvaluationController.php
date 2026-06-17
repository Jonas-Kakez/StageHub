<?php

namespace App\Http\Controllers\Encadreur;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Evaluation;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function create(Affectation $affectation)
    {
        $encadreur = auth()->user()->encadreur;

        if ($affectation->encadreur_id !== $encadreur->id) {
            abort(403);
        }

        $affectation->load(['etudiant.user', 'offreStage']);

        return view('encadreur.evaluations.create', compact('affectation', 'encadreur'));
    }

    public function store(Request $request, Affectation $affectation)
    {
        $encadreur = auth()->user()->encadreur;

        if ($affectation->encadreur_id !== $encadreur->id) {
            abort(403);
        }

        $validated = $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string|max:1000',
            'ponctualite' => 'nullable|numeric|min:0|max:5',
            'competence' => 'nullable|numeric|min:0|max:5',
            'initiative' => 'nullable|numeric|min:0|max:5',
        ]);

        Evaluation::updateOrCreate(
            [
                'affectation_id' => $affectation->id,
                'type' => 'encadreur',
            ],
            [
                'encadreur_id' => $encadreur->id,
                'evaluateur_user_id' => $request->user()->id,
                'note' => $validated['note'],
                'commentaire' => $validated['commentaire'],
                'criteres' => [
                    'ponctualite' => $validated['ponctualite'] ?? null,
                    'competence' => $validated['competence'] ?? null,
                    'initiative' => $validated['initiative'] ?? null,
                ],
            ]
        );

        NotificationService::send(
            $affectation->etudiant->user,
            'evaluation_encadreur',
            'Évaluation de l\'encadreur',
            'Votre encadreur a évalué votre stage.',
            route('etudiant.dashboard')
        );

        return redirect()->route('encadreur.stagiaires.index')
            ->with('success', 'Évaluation enregistrée.');
    }
}
