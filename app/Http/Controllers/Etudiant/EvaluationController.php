<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $etudiant = $request->user()->etudiant;
        $evaluations = $etudiant->evaluationsValidees();

        return view('etudiant.evaluations.index', compact('etudiant', 'evaluations'));
    }
}
