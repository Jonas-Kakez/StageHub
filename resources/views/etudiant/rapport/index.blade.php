@extends('layouts.dashboard')

@section('title', 'Rapport de stage')

@php
    $dashboardTitle = 'StageHub - Étudiant';
    $navColor = 'blue';
    $active = 'rapport';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Offres de stage', 'icon' => 'bi-search', 'url' => route('etudiant.offres.index'), 'activeClass' => 'active-blue'],
        ['key' => 'candidatures', 'label' => 'Mes candidatures', 'icon' => 'bi-briefcase', 'url' => route('etudiant.candidatures.index'), 'activeClass' => 'active-blue'],
        ['key' => 'profil', 'label' => 'Mon profil', 'icon' => 'bi-person', 'url' => route('etudiant.profil.edit'), 'activeClass' => 'active-blue'],
        ['key' => 'rapport', 'label' => 'Rapport de stage', 'icon' => 'bi-file-earmark-text', 'url' => route('etudiant.rapport.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Rapport de stage</h4>
<div class="card card-stagehub p-4">
    <p class="text-muted">Déposez votre rapport de stage une fois votre stage terminé.</p>

    @if($rapport)
        <div class="alert alert-info">
            Rapport « {{ $rapport->titre }} » — Statut: <strong>{{ $rapport->statut }}</strong>
            @if($rapport->commentaire_encadreur)
                <br>Commentaire: {{ $rapport->commentaire_encadreur }}
            @endif
        </div>
    @endif

    @if($affectation)
        <form action="{{ route('etudiant.rapport.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Titre du rapport</label>
                <input name="titre" class="form-control" placeholder="Exemple : Mon expérience chez TechCorp" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fichier PDF</label>
                <input type="file" name="fichier" class="form-control" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-stagehub-blue"><i class="bi bi-upload me-1"></i>Déposer le rapport</button>
        </form>
    @else
        <div class="alert alert-warning">Vous devez avoir un stage actif pour déposer un rapport.</div>
    @endif
</div>
@endsection
