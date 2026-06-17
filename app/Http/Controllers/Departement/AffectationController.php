<?php

namespace App\Http\Controllers\Departement;

use App\Http\Controllers\Controller;
use App\Models\Affectation;
use App\Models\Encadreur;
use App\Models\Etudiant;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index(Request $request)
    {
        $affectations = Affectation::with(['etudiant.user', 'etudiant.departement', 'offreStage', 'encadreur.user', 'entreprise'])
            ->where('statut', 'active')
            ->latest()
            ->paginate(10);

        $encadreurs = Encadreur::with('user')->get();

        return view('departement.affectations.index', compact('affectations', 'encadreurs'));
    }

    public function assignEncadreur(Request $request, Affectation $affectation)
    {
        $validated = $request->validate([
            'encadreur_id' => 'required|exists:encadreurs,id',
        ]);

        $affectation->update(['encadreur_id' => $validated['encadreur_id']]);
        $encadreur = Encadreur::find($validated['encadreur_id']);

        NotificationService::send(
            $encadreur->user,
            'encadrement',
            'Nouveau stagiaire assigné',
            "Vous encadrez maintenant {$affectation->etudiant->user->name}.",
            route('encadreur.stagiaires.index')
        );

        NotificationService::send(
            $affectation->etudiant->user,
            'encadreur_assigne',
            'Encadreur assigné',
            "Un encadreur a été assigné à votre stage.",
            route('etudiant.dashboard')
        );

        return back()->with('success', 'Encadreur assigné avec succès.');
    }
}
