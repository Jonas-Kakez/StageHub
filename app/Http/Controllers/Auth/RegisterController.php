<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm(string $role)
    {
        if (! in_array($role, ['etudiant', 'entreprise'], true)) {
            abort(404);
        }

        $departements = Departement::orderBy('nom')->get();

        return view('auth.register', compact('role', 'departements'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role');

        if ($role === 'etudiant') {
            return $this->registerEtudiant($request);
        }

        if ($role === 'entreprise') {
            return $this->registerEntreprise($request);
        }

        abort(404);
    }

    private function registerEtudiant(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'departement_id' => ['nullable', 'exists:departements,id'],
            'numero_etudiant' => ['nullable', 'string', 'max:50'],
            'niveau' => ['nullable', 'string', 'max:100'],
            'domaine' => ['nullable', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:30'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_ETUDIANT,
            ]);

            Etudiant::create([
                'user_id' => $user->id,
                'departement_id' => $validated['departement_id'] ?? null,
                'numero_etudiant' => $validated['numero_etudiant'] ?? null,
                'niveau' => $validated['niveau'] ?? null,
                'domaine' => $validated['domaine'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
            ]);

            Auth::login($user);
        });

        return redirect()->route('etudiant.dashboard');
    }

    private function registerEntreprise(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'nom' => ['required', 'string', 'max:255'],
            'secteur' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'pays' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => User::ROLE_ENTREPRISE,
            ]);

            Entreprise::create([
                'user_id' => $user->id,
                'nom' => $validated['nom'],
                'secteur' => $validated['secteur'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
                'adresse' => $validated['adresse'] ?? null,
                'ville' => $validated['ville'] ?? null,
                'province' => $validated['province'] ?? null,
                'pays' => $validated['pays'] ?? 'RDC',
                'latitude' => $validated['latitude'] ?? null,
                'longitude' => $validated['longitude'] ?? null,
                'description' => $validated['description'] ?? null,
                'statut_validation' => 'en_attente',
            ]);

            $admins = User::where('role', User::ROLE_ADMIN)->get();
            foreach ($admins as $admin) {
                NotificationService::send(
                    $admin,
                    'entreprise_inscription',
                    'Nouvelle entreprise inscrite',
                    "L'entreprise {$validated['nom']} a demandé une validation.",
                    route('admin.entreprises.index')
                );
            }

            Auth::login($user);
        });

        return redirect()->route('entreprise.dashboard')
            ->with('success', 'Inscription réussie. Votre entreprise est en attente de validation.');
    }
}
