<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RapportStage;
use Illuminate\Http\Request;

class RapportController extends Controller
{
    public function index()
    {
        $rapports = RapportStage::with(['etudiant.user', 'affectation.entreprise'])
            ->latest()
            ->paginate(10);

        return view('admin.rapports.index', compact('rapports'));
    }
}
