<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Encadreur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::withCount(['etudiants', 'encadreurs'])->get();

        return view('admin.departements.index', compact('departements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'faculte' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Departement::create($validated);

        return back()->with('success', 'Département créé.');
    }

    public function update(Request $request, Departement $departement)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'faculte' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $departement->update($validated);

        return back()->with('success', 'Département mis à jour.');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();

        return back()->with('success', 'Département supprimé.');
    }

    public function storeEncadreur(Request $request, Departement $departement)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'specialite' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($validated, $departement) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_ENCADREUR,
            ]);

            Encadreur::create([
                'user_id' => $user->id,
                'departement_id' => $departement->id,
                'specialite' => $validated['specialite'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
            ]);
        });

        return back()->with('success', 'Encadreur créé.');
    }
}
