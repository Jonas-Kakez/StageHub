<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index(Request $request)
    {
        $entreprises = Entreprise::with('user')
            ->withCount(['offresStage' => fn ($q) => $q->where('statut', 'active')])
            ->when($request->search, fn ($q, $s) => $q->where('nom', 'like', "%{$s}%"))
            ->latest()
            ->paginate(10);

        return view('admin.entreprises.index', compact('entreprises'));
    }

    public function show(Entreprise $entreprise)
    {
        $entreprise->load(['user', 'offresStage']);

        return view('admin.entreprises.show', compact('entreprise'));
    }

    public function valider(Entreprise $entreprise)
    {
        $entreprise->update([
            'statut_validation' => 'validee',
            'motif_refus' => null,
        ]);

        NotificationService::send(
            $entreprise->user,
            'entreprise_validee',
            'Entreprise validée',
            'Votre entreprise a été validée par l\'administration.',
            route('entreprise.dashboard')
        );

        return back()->with('success', 'Entreprise validée avec succès.');
    }

    public function refuser(Request $request, Entreprise $entreprise)
    {
        $request->validate(['motif_refus' => 'required|string|max:500']);

        $entreprise->update([
            'statut_validation' => 'refusee',
            'motif_refus' => $request->motif_refus,
        ]);

        NotificationService::send(
            $entreprise->user,
            'entreprise_refusee',
            'Entreprise refusée',
            'Votre demande a été refusée : '.$request->motif_refus,
            route('entreprise.dashboard')
        );

        return back()->with('success', 'Entreprise refusée.');
    }
}
