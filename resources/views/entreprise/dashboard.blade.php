@extends('layouts.dashboard')

@section('title', 'Entreprise')

@php
    $dashboardTitle = 'StageHub - Entreprise';
    $navColor = 'purple';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-speedometer2', 'url' => route('entreprise.dashboard')],
        ['key' => 'offres', 'label' => 'Mes offres', 'icon' => 'bi-briefcase', 'url' => route('entreprise.offres.index')],
        ['key' => 'create', 'label' => 'Publier une offre', 'icon' => 'bi-plus-lg', 'url' => route('entreprise.offres.create')],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-file-earmark-text', 'url' => route('entreprise.candidatures.index')],
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('entreprise.stagiaires.index')],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Tableau de bord</h4>
<div class="row g-3">
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['offres'] }}</div><div class="small text-muted">Offres</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['offres_actives'] }}</div><div class="small text-muted">Actives</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['candidatures'] }}</div><div class="small text-muted">Candidatures</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['stagiaires'] }}</div><div class="small text-muted">Stagiaires</div></div></div>
</div>
@endsection
