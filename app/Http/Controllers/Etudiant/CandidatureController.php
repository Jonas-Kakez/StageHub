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

        if (! $etudiant->peutPostuler()) {
            return back()->with('error', 'Vous avez déjà été accepté dans une entreprise. Vous ne pouvez plus postuler à d\'autres offres.');
        }

        if ($offre->quotaAtteint()) {
            NotificationService::send(
                $request->user(),
                'quota_atteint',
                'Quota atteint',
                "Le quota de l'offre « {$offre->titre} » est atteint. Votre candidature ne peut pas être enregistrée.",
                route('etudiant.offres.index')
            );

            return back()->with('error', 'Le quota de stagiaires pour cette offre est atteint.');
        }

        if ($etudiant->candidatures()->where('offre_stage_id', $offre->id)->exists()) {
            return back()->with('error', 'Vous avez déjà candidaté à cette offre.');
        }

        $request->validate([
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'lettre_motivation' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $etudiant, $offre) {
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
                'commentaire' => 'Candidature soumise — en attente de validation par le Bureau de stage UDBL',
            ]);

            $admins = User::where('role', User::ROLE_ADMIN)->get();
            foreach ($admins as $admin) {
                NotificationService::send(
                    $admin,
                    'nouvelle_candidature',
                    'Nouvelle candidature à examiner',
                    "{$request->user()->name} a candidaté pour « {$offre->titre} ».",
                    route('admin.candidatures.index')
                );
            }
        });

        return redirect()->route('etudiant.candidatures.index')
            ->with('success', 'Candidature envoyée. Elle sera transmise à l\'entreprise après validation par le Bureau de stage UDBL.');
    }
}
