<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OffreStage;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function index(Request $request)
    {
        $offres = OffreStage::with('entreprise')
            ->when($request->statut, fn ($q, $s) => $q->where('statut', $s))
            ->latest()
            ->paginate(10);

        return view('admin.offres.index', compact('offres'));
    }

    public function approuver(OffreStage $offre)
    {
        $offre->update([
            'statut' => 'active',
            'moderee' => true,
            'publie_le' => now(),
        ]);

        NotificationService::send(
            $offre->entreprise->user,
            'offre_approuvee',
            'Offre approuvée',
            "Votre offre « {$offre->titre} » a été publiée.",
            route('entreprise.offres.index')
        );

        return back()->with('success', 'Offre approuvée et publiée.');
    }

    public function refuser(Request $request, OffreStage $offre)
    {
        $request->validate(['motif_refus' => 'required|string|max:500']);

        $offre->update([
            'statut' => 'refusee',
            'motif_refus' => $request->motif_refus,
        ]);

        NotificationService::send(
            $offre->entreprise->user,
            'offre_refusee',
            'Offre refusée',
            "Votre offre « {$offre->titre} » a été refusée.",
            route('entreprise.offres.index')
        );

        return back()->with('success', 'Offre refusée.');
    }

    public function desactiver(OffreStage $offre)
    {
        $offre->update(['statut' => 'inactive']);

        return back()->with('success', 'Offre désactivée.');
    }
}
