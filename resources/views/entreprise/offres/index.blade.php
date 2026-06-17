@extends('layouts.dashboard')

@section('title', 'Entreprise')

@php
    $dashboardTitle = 'StageHub - Entreprise';
    $navColor = 'purple';
    $active = 'offres';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Mes offres', 'icon' => 'bi-briefcase', 'url' => route('entreprise.offres.index')],
        ['key' => 'create', 'label' => 'Publier une offre', 'icon' => 'bi-plus-lg', 'url' => route('entreprise.offres.create')],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-file-earmark-text', 'url' => route('entreprise.candidatures.index')],
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('entreprise.stagiaires.index')],
    ];
@endphp

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Mes offres de stage</h4>
    <a href="{{ route('entreprise.offres.create') }}" class="btn btn-stagehub btn-sm"><i class="bi bi-plus me-1"></i>Nouvelle offre</a>
</div>

@if(!$entreprise->isValidee())
    <div class="alert alert-warning">Votre entreprise est en attente de validation par l'administration.</div>
@endif

<div class="row g-3">
    @forelse($offres as $offre)
        <div class="col-md-6">
            <div class="card card-stagehub p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="fw-bold">{{ $offre->titre }}</h5>
                    <span class="badge badge-status-{{ $offre->statut }}">{{ ucfirst(str_replace('_', ' ', $offre->statut)) }}</span>
                </div>
                <p class="text-muted small mb-2">{{ $offre->departement_entreprise }}</p>
                <div class="d-flex gap-3 text-muted small mb-3">
                    <span><i class="bi bi-clock me-1"></i>{{ $offre->duree }}</span>
                    <span><i class="bi bi-people me-1"></i>{{ $offre->candidatures_count }} candidatures</span>
                    @if($offre->publie_le)
                        <span><i class="bi bi-calendar me-1"></i>Publié le {{ $offre->publie_le->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('entreprise.offres.edit', $offre) }}" class="btn btn-outline-secondary btn-sm">Modifier</a>
                    @if($offre->statut === 'active')
                        <form action="{{ route('entreprise.offres.desactiver', $offre) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">Désactiver</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="card card-stagehub p-4 text-center text-muted">Aucune offre publiée.</div></div>
    @endforelse
</div>
@endsection
