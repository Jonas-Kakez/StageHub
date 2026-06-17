@extends('layouts.dashboard')

@section('title', 'Modifier offre')

@php
    $dashboardTitle = 'StageHub - Entreprise';
    $navColor = 'purple';
    $active = 'offres';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Mes offres', 'icon' => 'bi-briefcase', 'url' => route('entreprise.offres.index')],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Modifier l'offre</h4>
<div class="card card-stagehub p-4">
    <form action="{{ route('entreprise.offres.update', $offre) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Titre</label><input name="titre" class="form-control" value="{{ $offre->titre }}" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Département</label><input name="departement_entreprise" class="form-control" value="{{ $offre->departement_entreprise }}"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Durée</label><input name="duree" class="form-control" value="{{ $offre->duree }}"></div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Localisation</label><input name="localisation" class="form-control" value="{{ $offre->localisation }}"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Type</label><input name="type_stage" class="form-control" value="{{ $offre->type_stage }}"></div>
        </div>
        <div class="mb-3"><label class="form-label">Domaine</label><input name="domaine" class="form-control" value="{{ $offre->domaine }}"></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="4">{{ $offre->description }}</textarea></div>
        <div class="mb-3"><label class="form-label">Compétences</label><input name="competences_requises" class="form-control" value="{{ $offre->competences_requises }}"></div>
        <button type="submit" class="btn btn-stagehub">Enregistrer</button>
    </form>
</div>
@endsection
