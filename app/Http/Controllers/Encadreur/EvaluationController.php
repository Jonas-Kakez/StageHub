<?php

namespace App\Http\Controllers\Encadreur;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Evaluation;
use App\Models\RapportStage;
use App\Models\User;
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

        if (! $affectation->estTermine()) {
            return redirect()->route('encadreur.stagiaires.index')
                ->with('error', 'L\'évaluation n\'est possible qu\'à la fin du stage.');
        }

        if ($affectation->evaluations()->where('type', 'encadreur')->exists()) {
            return redirect()->route('encadreur.stagiaires.index')
                ->with('error', 'Ce stagiaire a déjà été évalué.');
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

        if (! $affectation->estTermine()) {
            return back()->with('error', 'L\'évaluation n\'est possible qu\'à la fin du stage.');
        }

        if ($affectation->evaluations()->where('type', 'encadreur')->exists()) {
            return back()->with('error', 'Ce stagiaire a déjà été évalué.');
        }

        $validated = $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string|max:1000',
            'ponctualite' => 'nullable|numeric|min:0|max:5',
            'competence' => 'nullable|numeric|min:0|max:5',
            'initiative' => 'nullable|numeric|min:0|max:5',
        ]);

        Evaluation::create([
            'affectation_id' => $affectation->id,
            'type' => 'encadreur',
            'encadreur_id' => $encadreur->id,
            'evaluateur_user_id' => $request->user()->id,
            'note' => $validated['note'],
            'commentaire' => $validated['commentaire'],
            'criteres' => [
                'ponctualite' => $validated['ponctualite'] ?? null,
                'competence' => $validated['competence'] ?? null,
                'initiative' => $validated['initiative'] ?? null,
            ],
        ]);

        $affectation->update(['statut' => 'terminee']);
        $affectation->etudiant->update(['statut' => 'stage_termine']);

        $rapport = RapportStage::where('affectation_id', $affectation->id)->latest()->first();
        if ($rapport) {
            $rapport->update(['statut' => 'approuve']);
        }

        NotificationService::send(
            $affectation->etudiant->user,
            'evaluation_encadreur',
            'Évaluation enregistrée',
            'Votre encadreur a enregistré votre évaluation. En attente de validation par l\'UDBL.',
            route('etudiant.evaluations.index')
        );

        $admins = User::where('role', User::ROLE_ADMIN)->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin,
                'evaluation_a_valider',
                'Évaluation à valider',
                "Évaluation de {$affectation->etudiant->user->name} à valider.",
                route('admin.evaluations.index')
            );
        }

        NotificationService::send(
            $affectation->entreprise->user,
            'fin_stage',
            'Stage terminé',
            "Le stage de {$affectation->etudiant->user->name} est terminé.",
            route('entreprise.stagiaires.index')
        );

        return redirect()->route('encadreur.stagiaires.index')
            ->with('success', 'Évaluation enregistrée.');
    }
}
