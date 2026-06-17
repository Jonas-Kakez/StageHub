@extends('layouts.guest')

@section('title', 'Accueil')

@section('content')
<section class="hero-section">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">Plateforme de Gestion de Stages</h1>
        <p class="lead text-muted mb-4 mx-auto" style="max-width: 700px;">
            Connectez les étudiants, les entreprises et les établissements scolaires pour une gestion simplifiée et efficace des stages
        </p>
        <a href="{{ route('profil.select') }}" class="btn btn-stagehub btn-lg px-5">Commencer maintenant</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Fonctionnalités par profil</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-stagehub h-100 p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h5 class="fw-bold">Étudiant</h5>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Consultation des offres de stage</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Candidature en ligne simplifiée</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Suivi de l'état des candidatures</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Téléchargement de documents</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Dépôt du rapport de stage</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stagehub h-100 p-4">
                    <div class="feature-icon bg-purple bg-opacity-10 mb-3" style="background:#ede9fe;color:#7c3aed;">
                        <i class="bi bi-building"></i>
                    </div>
                    <h5 class="fw-bold">Entreprise</h5>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Publication d'offres de stage</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gestion des candidatures</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Acceptation/Refus des candidats</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Suivi des stagiaires actifs</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Évaluation des stagiaires</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stagehub h-100 p-4">
                    <div class="feature-icon bg-success bg-opacity-10 text-success mb-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="fw-bold">Administration</h5>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gestion des étudiants</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Gestion des entreprises</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Validation des stages</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Suivi global des stages</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Rapports et statistiques</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
