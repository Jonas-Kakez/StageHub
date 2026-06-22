<?php

namespace App\Http\Controllers\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\OffreStage;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $entreprise = $request->user()->entreprise;
        $offres = $entreprise->offresStage()
            ->withCount('candidatures')
            ->latest()
            ->get();

        return view('entreprise.offres.index', compact('offres', 'entreprise'));
    }

    public function create(Request $request)
    {
        $entreprise = $request->user()->entreprise;

        return view('entreprise.offres.create', compact('entreprise'));
    }

    public function store(Request $request)
    {
        $entreprise = $request->user()->entreprise;

        if (! $entreprise->isValidee()) {
            return back()->with('error', 'Votre entreprise doit être validée avant de publier des offres.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'departement_entreprise' => 'nullable|string|max:255',
            'duree' => 'nullable|string|max:100',
            'localisation' => 'nullable|string|max:255',
            'type_stage' => 'nullable|string|max:255',
            'domaine' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'competences_requises' => 'nullable|string',
            'quota_stagiaires' => 'required|integer|min:1|max:50',
        ]);

        $offre = $entreprise->offresStage()->create([
            ...$validated,
            'statut' => 'en_attente',
        ]);

        $admins = User::where('role', User::ROLE_ADMIN)->get();
        foreach ($admins as $admin) {
            NotificationService::send(
                $admin,
                'nouvelle_offre',
                'Nouvelle offre à modérer',
                "L'entreprise {$entreprise->nom} a publié « {$offre->titre} ».",
                route('admin.offres.index')
            );
        }

        return redirect()->route('entreprise.offres.index')
            ->with('success', 'Offre soumise pour modération.');
    }

    public function edit(OffreStage $offre)
    {
        $this->authorizeOffre($offre);

        return view('entreprise.offres.edit', compact('offre'));
    }

    public function update(Request $request, OffreStage $offre)
    {
        $this->authorizeOffre($offre);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'departement_entreprise' => 'nullable|string|max:255',
            'duree' => 'nullable|string|max:100',
            'localisation' => 'nullable|string|max:255',
            'type_stage' => 'nullable|string|max:255',
            'domaine' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'competences_requises' => 'nullable|string',
        ]);

        $offre->update($validated);

        return redirect()->route('entreprise.offres.index')
            ->with('success', 'Offre mise à jour.');
    }

    public function desactiver(OffreStage $offre)
    {
        $this->authorizeOffre($offre);
        $offre->update(['statut' => 'inactive']);

        return back()->with('success', 'Offre désactivée.');
    }

    private function authorizeOffre(OffreStage $offre): void
    {
        if ($offre->entreprise_id !== auth()->user()->entreprise->id) {
            abort(403);
        }
    }
}
