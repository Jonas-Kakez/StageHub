<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Candidature;
use App\Models\Traitement;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $entreprise = $request->user()->entreprise;
        $offreIds = $entreprise->offresStage()->pluck('id');

        $candidatures = Candidature::with(['etudiant.user', 'offreStage'])
            ->whereIn('offre_stage_id', $offreIds)
            ->latest()
            ->get();

        return view('entreprise.candidatures.index', compact('candidatures', 'entreprise'));
    }

    public function accepter(Request $request, Candidature $candidature)
    {
        $this->authorizeCandidature($candidature);

        DB::transaction(function () use ($candidature, $request) {
            $candidature->update(['statut' => 'acceptee']);

            Traitement::create([
                'candidature_id' => $candidature->id,
                'user_id' => $request->user()->id,
                'action' => 'acceptee',
                'commentaire' => 'Candidature acceptée par l\'entreprise',
            ]);

            NotificationService::send(
                $candidature->etudiant->user,
                'candidature_acceptee',
                'Candidature acceptée',
                "Votre candidature pour « {$candidature->offreStage->titre} » a été acceptée.",
                route('etudiant.candidatures.index')
            );
        });

        return back()->with('success', 'Candidature acceptée.');
    }

    public function refuser(Request $request, Candidature $candidature)
    {
        $this->authorizeCandidature($candidature);

        $request->validate(['motif_refus' => 'nullable|string|max:500']);

        DB::transaction(function () use ($candidature, $request) {
            $candidature->update([
                'statut' => 'refusee',
                'motif_refus' => $request->motif_refus,
            ]);

            Traitement::create([
                'candidature_id' => $candidature->id,
                'user_id' => $request->user()->id,
                'action' => 'refusee',
                'commentaire' => $request->motif_refus,
            ]);

            NotificationService::send(
                $candidature->etudiant->user,
                'candidature_refusee',
                'Candidature refusée',
                "Votre candidature pour « {$candidature->offreStage->titre} » a été refusée.",
                route('etudiant.candidatures.index')
            );
        });

        return back()->with('success', 'Candidature refusée.');
    }

    public function downloadCv(Candidature $candidature)
    {
        $this->authorizeCandidature($candidature);
        $path = $candidature->cv_path ?? $candidature->etudiant->cv_path;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->download($path);
    }

    private function authorizeCandidature(Candidature $candidature): void
    {
        $entreprise = auth()->user()->entreprise;
        if ($candidature->offreStage->entreprise_id !== $entreprise->id) {
            abort(403);
        }
    }
}
