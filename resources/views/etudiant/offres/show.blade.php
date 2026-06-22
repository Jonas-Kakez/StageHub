@extends('layouts.dashboard')

@section('title', $offre->titre)

@php
    $dashboardTitle = 'StageHub - Étudiant';
    $navColor = 'blue';
    $active = 'offres';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Offres de stage', 'icon' => 'bi-search', 'url' => route('etudiant.offres.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<div class="card card-stagehub p-4">
    <h4 class="fw-bold">{{ $offre->titre }}</h4>
    <p class="text-muted">{{ $offre->entreprise->nom }} — {{ $offre->localisation }}</p>
    <div class="row small mb-3">
        <div class="col-md-4"><strong>Durée:</strong> {{ $offre->duree }}</div>
        <div class="col-md-4"><strong>Type:</strong> {{ $offre->type_stage }}</div>
        <div class="col-md-4"><strong>Domaine:</strong> {{ $offre->domaine }}</div>
    </div>
    <p><strong>Description:</strong></p>
    <p>{{ $offre->description }}</p>
    <p><strong>Compétences:</strong> {{ $offre->competences_requises }}</p>
    @if($offre->entreprise->localisationComplete())
        <p><strong>Adresse entreprise:</strong> {{ $offre->entreprise->localisationComplete() }}</p>
    @endif

    <hr>
    @if(!$etudiant->peutPostuler())
        <div class="alert alert-warning">Vous avez déjà été accepté dans une entreprise. Vous ne pouvez plus postuler.</div>
    @elseif($offre->quotaAtteint())
        <div class="alert alert-warning">Le quota de stagiaires pour cette offre est atteint.</div>
    @else
    <h6 class="fw-bold">Postuler</h6>
    <form action="{{ route('etudiant.candidatures.store', $offre) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">CV (PDF)</label>
                <input type="file" name="cv" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Lettre de motivation (PDF)</label>
                <input type="file" name="lettre_motivation" class="form-control" accept=".pdf">
            </div>
        </div>
        <button type="submit" class="btn btn-stagehub-blue">Envoyer candidature</button>
    </form>
    @endif
</div>
@endsection
