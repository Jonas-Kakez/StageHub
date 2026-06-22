<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluation;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with(['affectation.etudiant.user', 'affectation.offreStage', 'encadreur.user'])
            ->latest()
            ->paginate(15);

        return view('admin.evaluations.index', compact('evaluations'));
    }

    public function valider(Evaluation $evaluation)
    {
        $evaluation->update(['validee_institution' => true]);

        NotificationService::send(
            $evaluation->affectation->etudiant->user,
            'evaluation_validee',
            'Note d\'évaluation disponible',
            'Votre note d\'évaluation pour le stage « '.$evaluation->affectation->offreStage->titre.' » est disponible.',
            route('etudiant.evaluations.index')
        );

        return back()->with('success', 'Évaluation validée. L\'étudiant peut consulter sa note.');
    }
}
