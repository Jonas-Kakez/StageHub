<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\OffreStage;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $offres = OffreStage::with('entreprise')
            ->where('statut', 'active')
            ->when($request->domaine, fn ($q, $d) => $q->where('domaine', 'like', "%{$d}%"))
            ->when($request->competence, fn ($q, $c) => $q->where('competences_requises', 'like', "%{$c}%"))
            ->when($request->localisation, fn ($q, $l) => $q->where('localisation', 'like', "%{$l}%"))
            ->when($request->search, fn ($q, $s) => $q->where('titre', 'like', "%{$s}%"))
            ->latest('publie_le')
            ->paginate(9);

        return view('etudiant.offres.index', compact('offres'));
    }

    public function show(OffreStage $offre)
    {
        if ($offre->statut !== 'active') {
            abort(404);
        }

        $offre->load('entreprise');

        return view('etudiant.offres.show', compact('offre'));
    }
}
