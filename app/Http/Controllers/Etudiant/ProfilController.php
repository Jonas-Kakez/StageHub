<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function edit(Request $request)
    {
        $etudiant = $request->user()->etudiant->load('departement');

        return view('etudiant.profil.edit', compact('etudiant'));
    }

    public function update(Request $request)
    {
        $etudiant = $request->user()->etudiant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:30',
            'niveau' => 'nullable|string|max:100',
            'domaine' => 'nullable|string|max:100',
            'competences' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf|max:5120',
            'lettre_motivation' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $request->user()->update(['name' => $validated['name']]);

        $data = collect($validated)->except(['name', 'cv', 'lettre_motivation'])->toArray();

        if ($request->hasFile('cv')) {
            if ($etudiant->cv_path) {
                Storage::disk('public')->delete($etudiant->cv_path);
            }
            $data['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        if ($request->hasFile('lettre_motivation')) {
            if ($etudiant->lettre_motivation_path) {
                Storage::disk('public')->delete($etudiant->lettre_motivation_path);
            }
            $data['lettre_motivation_path'] = $request->file('lettre_motivation')->store('lettres', 'public');
        }

        $etudiant->update($data);

        return back()->with('success', 'Profil mis à jour.');
    }
}
