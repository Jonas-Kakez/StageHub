<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index(Request $request)
    {
        $etudiants = Etudiant::with(['user', 'departement'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%"));
            })
            ->latest()
            ->paginate(10);

        return view('admin.etudiants.index', compact('etudiants'));
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load(['user', 'departement', 'candidatures.offreStage', 'affectations.entreprise']);

        return view('admin.etudiants.show', compact('etudiant'));
    }
}
