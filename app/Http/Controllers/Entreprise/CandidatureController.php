<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Traitement;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $entreprise = $request->user()->entreprise;
        $offreIds = $entreprise->offresStage()->pluck('id');

        $candidatures = Candidature::with(['etudiant.user', 'offreStage'])
            ->whereIn('offre_stage_id', $offreIds)
            ->whereIn('statut', ['transmise', 'acceptee', 'refusee'])
            ->latest()
            ->get();

        $stats = [
            'total' => $candidatures->count(),
            'transmises' => $candidatures->where('statut', 'transmise')->count(),
            'acceptees' => $candidatures->where('statut', 'acceptee')->count(),
            'par_niveau' => $candidatures->groupBy(fn ($c) => $c->etudiant->niveau ?? 'Non renseigné')->map->count(),
        ];

        return view('entreprise.candidatures.index', compact('candidatures', 'entreprise', 'stats'));
    }

    public function accepter(Request $request, Candidature $candidature)
    {
        $this->authorizeCandidature($candidature);

        if ($candidature->statut !== 'transmise') {
            return back()->with('error', 'Seules les candidatures transmises par l\'UDBL peuvent être acceptées.');
        }

        if ($candidature->offreStage->quotaAtteint()) {
            return back()->with('error', 'Le quota de stagiaires pour cette offre est atteint.');
        }

        DB::transaction(function () use ($candidature, $request) {
            $candidature->update(['statut' => 'acceptee']);
            $candidature->etudiant->update(['statut' => 'en_stage']);

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

            $admins = \App\Models\User::where('role', \App\Models\User::ROLE_ADMIN)->get();
            foreach ($admins as $admin) {
                NotificationService::send(
                    $admin,
                    'candidature_acceptee',
                    'Étudiant accepté',
                    "{$candidature->etudiant->user->name} accepté chez {$request->user()->entreprise->nom}.",
                    route('admin.candidatures.index')
                );
            }
        });

        return back()->with('success', 'Candidature acceptée.');
    }

    public function refuser(Request $request, Candidature $candidature)
    {
        $this->authorizeCandidature($candidature);

        if (! in_array($candidature->statut, ['transmise'], true)) {
            return back()->with('error', 'Cette candidature ne peut plus être refusée.');
        }

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

        if (! $path || ! \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($path);
    }

    private function authorizeCandidature(Candidature $candidature): void
    {
        $entreprise = auth()->user()->entreprise;
        if ($candidature->offreStage->entreprise_id !== $entreprise->id) {
            abort(403);
        }
    }
}
