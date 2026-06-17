@extends('layouts.dashboard')

@section('title', 'Mes candidatures')

@php
    $dashboardTitle = 'StageHub - Étudiant';
    $navColor = 'blue';
    $active = 'candidatures';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Offres de stage', 'icon' => 'bi-search', 'url' => route('etudiant.offres.index'), 'activeClass' => 'active-blue'],
        ['key' => 'candidatures', 'label' => 'Mes candidatures', 'icon' => 'bi-briefcase', 'url' => route('etudiant.candidatures.index'), 'activeClass' => 'active-blue'],
        ['key' => 'profil', 'label' => 'Mon profil', 'icon' => 'bi-person', 'url' => route('etudiant.profil.edit'), 'activeClass' => 'active-blue'],
        ['key' => 'rapport', 'label' => 'Rapport de stage', 'icon' => 'bi-file-earmark-text', 'url' => route('etudiant.rapport.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Mes candidatures</h4>
@forelse($candidatures as $c)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="fw-bold">{{ $c->offreStage->titre }}</h5>
                <p class="text-muted small">{{ $c->offreStage->entreprise->nom }}</p>
                <p class="text-muted small">Candidature du {{ $c->created_at->format('d/m/Y') }}</p>
            </div>
            <span class="badge badge-status-{{ $c->statut }}">{{ str_replace('_', ' ', ucfirst($c->statut)) }}</span>
        </div>
        @if($c->motif_refus)
            <p class="small text-danger mt-2">Motif: {{ $c->motif_refus }}</p>
        @endif
    </div>
@empty
    <div class="card card-stagehub p-4 text-muted text-center">Aucune candidature.</div>
@endforelse
@endsection
