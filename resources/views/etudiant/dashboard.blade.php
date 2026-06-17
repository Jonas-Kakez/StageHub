@extends('layouts.dashboard')

@section('title', 'Étudiant')

@php
    $dashboardTitle = 'StageHub - Étudiant';
    $navColor = 'blue';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-speedometer2', 'url' => route('etudiant.dashboard'), 'activeClass' => 'active-blue'],
        ['key' => 'offres', 'label' => 'Offres de stage', 'icon' => 'bi-search', 'url' => route('etudiant.offres.index'), 'activeClass' => 'active-blue'],
        ['key' => 'candidatures', 'label' => 'Mes candidatures', 'icon' => 'bi-briefcase', 'url' => route('etudiant.candidatures.index'), 'activeClass' => 'active-blue'],
        ['key' => 'profil', 'label' => 'Mon profil', 'icon' => 'bi-person', 'url' => route('etudiant.profil.edit'), 'activeClass' => 'active-blue'],
        ['key' => 'rapport', 'label' => 'Rapport de stage', 'icon' => 'bi-file-earmark-text', 'url' => route('etudiant.rapport.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Tableau de bord</h4>
<div class="row g-3">
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['candidatures'] }}</div><div class="small text-muted">Candidatures</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['en_attente'] }}</div><div class="small text-muted">En attente</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['acceptees'] }}</div><div class="small text-muted">Acceptées</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['affectations'] }}</div><div class="small text-muted">Stages actifs</div></div></div>
</div>
<a href="{{ route('etudiant.offres.index') }}" class="btn btn-stagehub-blue mt-4">Rechercher des offres</a>
@endsection
