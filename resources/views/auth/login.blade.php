@extends('layouts.guest')

@section('title', 'Connexion '.$roleLabel)

@section('content')
<div class="container py-4">
    <div class="auth-card">
        <a href="{{ route('profil.select') }}" class="text-muted small"><i class="bi bi-arrow-left me-1"></i> Changer de profil</a>

        <div class="card card-stagehub p-4 mt-3">
            <div class="text-center mb-4">
                @if($role === 'etudiant')
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                @elseif($role === 'entreprise')
                    <div class="feature-icon mx-auto mb-3" style="background:#ede9fe;color:#7c3aed;">
                        <i class="bi bi-building"></i>
                    </div>
                @else
                    <div class="feature-icon bg-success bg-opacity-10 text-success mx-auto mb-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                @endif
                <h4 class="fw-bold">Connexion {{ $roleLabel }}</h4>
                <p class="text-muted small">Entrez vos identifiants pour continuer</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger small">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">

                <div class="mb-3">
                    <label class="form-label">Adresse email</label>
                    <input type="email" name="email" class="form-control" placeholder="exemple@email.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                    </div>
                </div>

                @if($role === 'etudiant')
                    <button type="submit" class="btn btn-stagehub-blue w-100">Se connecter</button>
                @elseif($role === 'entreprise')
                    <button type="submit" class="btn btn-stagehub w-100">Se connecter</button>
                @else
                    <button type="submit" class="btn btn-stagehub-green w-100">Se connecter</button>
                @endif
            </form>

            @if(in_array($role, ['etudiant', 'entreprise']))
                <p class="text-center text-muted small mt-4">
                    Pas encore de compte ?
                    <a href="{{ route('register', $role) }}" class="text-decoration-none" style="color:#7c3aed;">S'inscrire</a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
