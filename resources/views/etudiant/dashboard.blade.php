@extends('layouts.dashboard')

@section('title', 'Étudiant')

@php
    $dashboardTitle = 'StageHub UDBL - Étudiant';
    $navColor = 'blue';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-speedometer2', 'url' => route('etudiant.dashboard'), 'activeClass' => 'active-blue'],
        ['key' => 'offres', 'label' => 'Offres de stage', 'icon' => 'bi-search', 'url' => route('etudiant.offres.index'), 'activeClass' => 'active-blue'],
        ['key' => 'candidatures', 'label' => 'Mes candidatures', 'icon' => 'bi-briefcase', 'url' => route('etudiant.candidatures.index'), 'activeClass' => 'active-blue'],
        ['key' => 'evaluations', 'label' => 'Mes notes', 'icon' => 'bi-star', 'url' => route('etudiant.evaluations.index'), 'activeClass' => 'active-blue'],
        ['key' => 'profil', 'label' => 'Mon profil', 'icon' => 'bi-person', 'url' => route('etudiant.profil.edit'), 'activeClass' => 'active-blue'],
        ['key' => 'rapport', 'label' => 'Rapport de stage', 'icon' => 'bi-file-earmark-text', 'url' => route('etudiant.rapport.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Bienvenue, {{ auth()->user()->name }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold text-primary">{{ $stats['candidatures'] }}</div><div class="small text-muted">Candidatures</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['en_attente'] }}</div><div class="small text-muted">En cours</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold text-success">{{ $stats['acceptees'] }}</div><div class="small text-muted">Acceptées</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['affectations'] }}</div><div class="small text-muted">Stages actifs</div></div></div>
</div>

@if(!$etudiant->peutPostuler())
    <div class="alert alert-info">Vous avez été accepté dans une entreprise. Vous ne pouvez plus postuler à d'autres offres.</div>
@endif

<h5 class="fw-bold mb-3"><i class="bi bi-briefcase me-2"></i>Offres de stage disponibles</h5>
<div class="offres-carousel mb-4">
    <div class="offres-track">
        @foreach($offresRecentes->concat($offresRecentes) as $offre)
            <div class="offre-slide">
                <div class="card card-stagehub p-3 h-100">
                    <h6 class="fw-bold mb-1">{{ $offre->titre }}</h6>
                    <p class="text-muted small mb-1">{{ $offre->entreprise->nom }}</p>
                    <p class="small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $offre->localisation }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $offre->placesRestantes() }} place(s)</span>
                        <a href="{{ route('etudiant.offres.show', $offre) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<a href="{{ route('etudiant.offres.index') }}" class="btn btn-stagehub-blue">Voir toutes les offres</a>
@endsection
