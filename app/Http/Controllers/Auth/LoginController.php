<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function showLoginForm(Request $request, string $role)
    {
        $roles = [
            'etudiant' => User::ROLE_ETUDIANT,
            'entreprise' => User::ROLE_ENTREPRISE,
            'admin' => User::ROLE_ADMIN,
            'departement' => User::ROLE_DEPARTEMENT,
            'encadreur' => User::ROLE_ENCADREUR,
        ];

        if (! isset($roles[$role])) {
            abort(404);
        }

        return view('auth.login', [
            'role' => $role,
            'roleLabel' => $this->roleLabel($role),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:etudiant,entreprise,admin,departement,encadreur'],
        ]);

        $credentials = $request->only('email', 'password');
        $roleMap = [
            'etudiant' => User::ROLE_ETUDIANT,
            'entreprise' => User::ROLE_ENTREPRISE,
            'admin' => User::ROLE_ADMIN,
            'departement' => User::ROLE_DEPARTEMENT,
            'encadreur' => User::ROLE_ENCADREUR,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->role !== $roleMap[$request->role]) {
                Auth::logout();
                return back()->withErrors(['email' => 'Ce compte ne correspond pas au profil sélectionné.']);
            }

            if (! $user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte est désactivé.']);
            }

            $request->session()->regenerate();

            return redirect()->intended($user->dashboardRoute());
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function roleLabel(string $role): string
    {
        return match ($role) {
            'etudiant' => 'Étudiant',
            'entreprise' => 'Entreprise',
            'admin' => 'Administration',
            'departement' => 'Département',
            'encadreur' => 'Encadreur',
            default => ucfirst($role),
        };
    }
}
