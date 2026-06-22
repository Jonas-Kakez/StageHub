<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\RapportStage;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $etudiant = $request->user()->etudiant;
        $affectation = $etudiant->affectations()->whereIn('statut', ['active', 'terminee'])->latest()->first();
        $rapport = $etudiant->rapportStages()->latest()->first();

        return view('etudiant.rapport.index', compact('etudiant', 'affectation', 'rapport'));
    }

    public function store(Request $request)
    {
        $etudiant = $request->user()->etudiant;
        $affectation = $etudiant->affectations()->whereIn('statut', ['active', 'terminee'])->latest()->first();

        if (! $affectation) {
            return back()->with('error', 'Vous n\'avez pas de stage enregistré.');
        }

        if (! $affectation->peutDeposerRapport()) {
            return back()->with('error', 'Le dépôt du rapport est possible uniquement à la fin effective du stage.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|mimes:pdf|max:10240',
        ]);

        $path = $request->file('fichier')->store('rapports', 'public');

        RapportStage::create([
            'affectation_id' => $affectation->id,
            'etudiant_id' => $etudiant->id,
            'titre' => $validated['titre'],
            'fichier_path' => $path,
            'statut' => 'soumis',
        ]);

        if ($affectation->encadreur) {
            NotificationService::send(
                $affectation->encadreur->user,
                'rapport_soumis',
                'Nouveau rapport de stage',
                "{$request->user()->name} a déposé un rapport de stage.",
                route('encadreur.rapports.index')
            );
        }

        $admins = User::where('role', User::ROLE_ADMIN)->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin,
                'rapport_soumis',
                'Rapport de stage déposé',
                "{$request->user()->name} a déposé son rapport de stage.",
                route('admin.rapports.index')
            );
        }

        return back()->with('success', 'Rapport déposé avec succès.');
    }
}
