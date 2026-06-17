<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\OffreStage;
use App\Models\Traitement;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $etudiant = $request->user()->etudiant;
        $candidatures = $etudiant->candidatures()
            ->with(['offreStage.entreprise', 'affectation'])
            ->latest()
            ->get();

        return view('etudiant.candidatures.index', compact('candidatures', 'etudiant'));
    }

    public function store(Request $request, OffreStage $offre)
    {
        $etudiant = $request->user()->etudiant;

        if ($offre->statut !== 'active') {
            return back()->with('error', 'Cette offre n\'est plus disponible.');
        }

        if ($etudiant->candidatures()->where('offre_stage_id', $offre->id)->exists()) {
            return back()->with('error', 'Vous avez déjà candidaté à cette offre.');
        }

        $validated = $request->validate([
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'lettre_motivation' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $etudiant, $offre, $validated) {
            $cvPath = $etudiant->cv_path;
            $lettrePath = $etudiant->lettre_motivation_path;

            if ($request->hasFile('cv')) {
                $cvPath = $request->file('cv')->store('cvs', 'public');
                $etudiant->update(['cv_path' => $cvPath]);
            }

            if ($request->hasFile('lettre_motivation')) {
                $lettrePath = $request->file('lettre_motivation')->store('lettres', 'public');
                $etudiant->update(['lettre_motivation_path' => $lettrePath]);
            }

            $candidature = Candidature::create([
                'etudiant_id' => $etudiant->id,
                'offre_stage_id' => $offre->id,
                'cv_path' => $cvPath,
                'lettre_motivation_path' => $lettrePath,
                'statut' => 'en_attente',
            ]);

            Traitement::create([
                'candidature_id' => $candidature->id,
                'user_id' => $request->user()->id,
                'action' => 'soumise',
                'commentaire' => 'Candidature soumise',
            ]);

            NotificationService::send(
                $offre->entreprise->user,
                'nouvelle_candidature',
                'Nouvelle candidature',
                "{$request->user()->name} a candidaté pour « {$offre->titre} ».",
                route('entreprise.candidatures.index')
            );
        });

        return redirect()->route('etudiant.candidatures.index')
            ->with('success', 'Candidature envoyée avec succès.');
    }
}
