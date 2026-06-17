@extends('layouts.guest')

@section('title', 'Inscription')

@section('content')
<div class="container py-4">
    <div class="auth-card" style="max-width:600px;">
        <a href="{{ route('login', $role) }}" class="text-muted small"><i class="bi bi-arrow-left me-1"></i> Retour connexion</a>
        <div class="card card-stagehub p-4 mt-3">
            <h4 class="fw-bold text-center mb-4">Inscription {{ $role === 'etudiant' ? 'Étudiant' : 'Entreprise' }}</h4>
            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">
                <div class="mb-3">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmer</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                @if($role === 'etudiant')
                    <div class="mb-3">
                        <label class="form-label">Département</label>
                        <select name="departement_id" class="form-select">
                            <option value="">— Sélectionner —</option>
                            @foreach($departements as $d)
                                <option value="{{ $d->id }}">{{ $d->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Niveau</label>
                            <input type="text" name="niveau" class="form-control" placeholder="Master Informatique">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Domaine</label>
                            <input type="text" name="domaine" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control">
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label">Nom de l'entreprise</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Secteur</label>
                            <input type="text" name="secteur" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ville</label>
                            <input type="text" name="ville" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Province</label>
                            <input type="text" name="province" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pays</label>
                            <input type="text" name="pays" class="form-control" value="RDC">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="any" name="latitude" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="any" name="longitude" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                @endif
                <button type="submit" class="btn btn-stagehub w-100">S'inscrire</button>
            </form>
        </div>
    </div>
</div>
@endsection
