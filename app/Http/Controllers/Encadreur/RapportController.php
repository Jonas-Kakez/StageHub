<?php

namespace App\Http\Controllers\Encadreur;

use App\Http\Controllers\Controller;
use App\Models\RapportStage;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $encadreur = $request->user()->encadreur;
        $affectationIds = $encadreur->affectations()->pluck('id');

        $rapports = RapportStage::with(['etudiant.user', 'affectation.offreStage'])
            ->whereIn('affectation_id', $affectationIds)
            ->latest()
            ->get();

        return view('encadreur.rapports.index', compact('rapports', 'encadreur'));
    }

    public function download(RapportStage $rapport)
    {
        $this->authorizeRapport($rapport);

        if (! Storage::disk('public')->exists($rapport->fichier_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($rapport->fichier_path);
    }

    public function commenter(Request $request, RapportStage $rapport)
    {
        $this->authorizeRapport($rapport);

        $validated = $request->validate([
            'statut' => 'required|in:en_revision,approuve,refuse',
            'commentaire_encadreur' => 'nullable|string|max:1000',
        ]);

        $rapport->update($validated);

        NotificationService::send(
            $rapport->etudiant->user,
            'rapport_commentaire',
            'Rapport examiné',
            'Votre rapport de stage a été examiné par votre encadreur.',
            route('etudiant.rapport.index')
        );

        return back()->with('success', 'Rapport mis à jour.');
    }

    private function authorizeRapport(RapportStage $rapport): void
    {
        $encadreur = auth()->user()->encadreur;
        $affectation = $rapport->affectation;

        if (! $encadreur || $affectation->encadreur_id !== $encadreur->id) {
            abort(403);
        }
    }
}
