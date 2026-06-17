@extends('layouts.guest')

@section('title', 'Choisir votre profil')

@section('content')
<div class="container py-5">
    <a href="{{ route('home') }}" class="text-muted small"><i class="bi bi-arrow-left me-1"></i> Retour</a>

    <div class="card card-stagehub mx-auto mt-3 p-5" style="max-width: 900px;">
        <h2 class="text-center fw-bold mb-2">Choisissez votre profil</h2>
        <p class="text-center text-muted mb-5">Sélectionnez le type de compte avec lequel vous souhaitez vous connecter</p>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('login', 'etudiant') }}" class="text-decoration-none">
                    <div class="card profile-card card-stagehub p-4 text-center h-100">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h5 class="fw-bold">Étudiant</h5>
                        <p class="text-muted small">Recherchez et postulez à des stages</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('login', 'entreprise') }}" class="text-decoration-none">
                    <div class="card profile-card card-stagehub p-4 text-center h-100">
                        <div class="feature-icon mx-auto mb-3" style="background:#ede9fe;color:#7c3aed;">
                            <i class="bi bi-building"></i>
                        </div>
                        <h5 class="fw-bold">Entreprise</h5>
                        <p class="text-muted small">Publiez des offres et recrutez des stagiaires</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('login', 'admin') }}" class="text-decoration-none">
                    <div class="card profile-card card-stagehub p-4 text-center h-100">
                        <div class="feature-icon bg-success bg-opacity-10 text-success mx-auto mb-3">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h5 class="fw-bold">Administration</h5>
                        <p class="text-muted small">Gérez la plateforme et les utilisateurs</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <a href="{{ route('login', 'departement') }}" class="text-decoration-none">
                    <div class="card profile-card card-stagehub p-3 text-center">
                        <h6 class="fw-bold mb-1">Département</h6>
                        <p class="text-muted small mb-0">Attribuer les encadreurs</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('login', 'encadreur') }}" class="text-decoration-none">
                    <div class="card profile-card card-stagehub p-3 text-center">
                        <h6 class="fw-bold mb-1">Encadreur</h6>
                        <p class="text-muted small mb-0">Suivre et évaluer les stagiaires</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
