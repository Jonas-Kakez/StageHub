@extends('layouts.dashboard')

@section('title', 'Publier une offre')

@php
    $dashboardTitle = 'StageHub - Entreprise';
    $navColor = 'purple';
    $active = 'create';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Mes offres', 'icon' => 'bi-briefcase', 'url' => route('entreprise.offres.index')],
        ['key' => 'create', 'label' => 'Publier une offre', 'icon' => 'bi-plus-lg', 'url' => route('entreprise.offres.create')],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-file-earmark-text', 'url' => route('entreprise.candidatures.index')],
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('entreprise.stagiaires.index')],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Publier une nouvelle offre</h4>
<div class="card card-stagehub p-4">
    <form action="{{ route('entreprise.offres.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Titre du poste</label>
            <input name="titre" class="form-control" placeholder="Ex: Stage Développeur Web" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Département</label>
                <input name="departement_entreprise" class="form-control" placeholder="Ex: IT, Marketing...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Durée</label>
                <input name="duree" class="form-control" placeholder="Ex: 6 mois">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Localisation</label>
                <input name="localisation" class="form-control" placeholder="Ex: Kolwezi">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Type de stage</label>
                <input name="type_stage" class="form-control" placeholder="Ex: Informatique">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Domaine</label>
            <input name="domaine" class="form-control" placeholder="Ex: Informatique">
        </div>
        <div class="mb-3">
            <label class="form-label">Description du poste</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Décrivez les missions, compétences requises..."></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Compétences requises</label>
            <input name="competences_requises" class="form-control" placeholder="Ex: JavaScript, React, Node.js...">
        </div>
        <button type="submit" class="btn btn-stagehub"><i class="bi bi-plus me-1"></i>Publier l'offre</button>
    </form>
</div>
@endsection
