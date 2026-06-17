<?php

namespace App\Http\Controllers\Encadreur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function index(Request $request)
    {
        $encadreur = $request->user()->encadreur;
        $stagiaires = $encadreur->affectations()
            ->with(['etudiant.user', 'offreStage', 'entreprise', 'rapportStage'])
            ->where('statut', 'active')
            ->get();

        return view('encadreur.stagiaires.index', compact('stagiaires', 'encadreur'));
    }
}
