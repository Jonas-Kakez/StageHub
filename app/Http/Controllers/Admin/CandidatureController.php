<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Traitement;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $candidatures = Candidature::with(['etudiant.user', 'offreStage.entreprise'])
            ->when($request->statut, fn ($q, $s) => $q->where('statut', $s))
            ->latest()
            ->paginate(15);

        return view('admin.candidatures.index', compact('candidatures'));
    }

    public function transmettre(Candidature $candidature)
    {
        if ($candidature->statut !== 'en_attente') {
            return back()->with('error', 'Cette candidature ne peut plus être transmise.');
        }

        $candidature->update(['statut' => 'transmise']);

        Traitement::create([
            'candidature_id' => $candidature->id,
            'user_id' => auth()->id(),
            'action' => 'transmise',
            'commentaire' => 'Candidature validée et transmise à l\'entreprise par le Bureau de stage UDBL',
        ]);

        NotificationService::send(
            $candidature->offreStage->entreprise->user,
            'candidature_transmise',
            'Candidature transmise',
            "La candidature de {$candidature->etudiant->user->name} pour « {$candidature->offreStage->titre} » a été transmise par l'UDBL.",
            route('entreprise.candidatures.index')
        );

        NotificationService::send(
            $candidature->etudiant->user,
            'candidature_transmise',
            'Candidature transmise',
            "Votre candidature pour « {$candidature->offreStage->titre} » a été transmise à l'entreprise.",
            route('etudiant.candidatures.index')
        );

        return back()->with('success', 'Candidature transmise à l\'entreprise.');
    }

    public function refuser(Request $request, Candidature $candidature)
    {
        $request->validate(['motif_refus' => 'required|string|max:500']);

        $candidature->update([
            'statut' => 'refusee',
            'motif_refus' => $request->motif_refus,
        ]);

        Traitement::create([
            'candidature_id' => $candidature->id,
            'user_id' => auth()->id(),
            'action' => 'refusee_institution',
            'commentaire' => $request->motif_refus,
        ]);

        NotificationService::send(
            $candidature->etudiant->user,
            'candidature_refusee',
            'Candidature refusée',
            "Votre candidature pour « {$candidature->offreStage->titre} » a été refusée par le Bureau de stage.",
            route('etudiant.candidatures.index')
        );

        return back()->with('success', 'Candidature refusée.');
    }
}
