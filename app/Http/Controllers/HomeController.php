<?php

namespace App\Http\Controllers;

use App\Models\OffreStage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $offresCount = OffreStage::where('statut', 'active')->count();

        return view('welcome', compact('offresCount'));
    }

    public function profil()
    {
        return view('auth.profil-select');
    }
}
