@extends('layouts.dashboard')

@section('title', 'Offres de stage')

@php
    $dashboardTitle = 'StageHub - Étudiant';
    $navColor = 'blue';
    $active = 'offres';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Offres de stage', 'icon' => 'bi-search', 'url' => route('etudiant.offres.index'), 'activeClass' => 'active-blue'],
        ['key' => 'candidatures', 'label' => 'Mes candidatures', 'icon' => 'bi-briefcase', 'url' => route('etudiant.candidatures.index'), 'activeClass' => 'active-blue'],
        ['key' => 'profil', 'label' => 'Mon profil', 'icon' => 'bi-person', 'url' => route('etudiant.profil.edit'), 'activeClass' => 'active-blue'],
        ['key' => 'rapport', 'label' => 'Rapport de stage', 'icon' => 'bi-file-earmark-text', 'url' => route('etudiant.rapport.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Offres de stage</h4>
<form method="GET" class="card card-stagehub p-3 mb-4">
    <div class="row g-2">
        <div class="col-md-3"><input name="search" class="form-control form-control-sm" placeholder="Rechercher..." value="{{ request('search') }}"></div>
        <div class="col-md-3"><input name="domaine" class="form-control form-control-sm" placeholder="Domaine" value="{{ request('domaine') }}"></div>
        <div class="col-md-3"><input name="competence" class="form-control form-control-sm" placeholder="Compétence" value="{{ request('competence') }}"></div>
        <div class="col-md-3"><input name="localisation" class="form-control form-control-sm" placeholder="Localisation" value="{{ request('localisation') }}"></div>
        <div class="col-12"><button class="btn btn-stagehub-blue btn-sm">Filtrer</button></div>
    </div>
</form>
<div class="row g-3">
    @foreach($offres as $offre)
        <div class="col-md-4">
            <div class="card card-stagehub p-4 h-100">
                <h5 class="fw-bold">{{ $offre->titre }}</h5>
                <p class="text-muted small">{{ $offre->entreprise->nom }}</p>
                <p class="small"><i class="bi bi-geo-alt me-1"></i>{{ $offre->localisation }}</p>
                <p class="small"><i class="bi bi-clock me-1"></i>{{ $offre->duree }}</p>
                <a href="{{ route('etudiant.offres.show', $offre) }}" class="btn btn-outline-primary btn-sm mt-2">Voir détails</a>
            </div>
        </div>
    @endforeach
</div>
{{ $offres->links() }}
@endsection
