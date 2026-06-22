@extends('layouts.dashboard')

@section('title', 'Publier offre UDBL')

@php
    $dashboardTitle = 'Bureau de stage UDBL';
    $navColor = 'green';
    $active = 'offres';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Stages', 'icon' => 'bi-briefcase', 'url' => route('admin.offres.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Publier une offre pour une entreprise</h4>
<p class="text-muted">Pour les entreprises non inscrites sur la plateforme, le Bureau de stage peut publier l'offre en leur nom.</p>
<div class="card card-stagehub p-4">
    <form action="{{ route('admin.offres.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Entreprise</label>
            <select name="entreprise_id" class="form-select" required>
                @foreach($entreprises as $e)
                    <option value="{{ $e->id }}">{{ $e->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label class="form-label">Titre</label><input name="titre" class="form-control" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Département</label><input name="departement_entreprise" class="form-control"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Durée</label><input name="duree" class="form-control"></div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Localisation</label><input name="localisation" class="form-control"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Domaine</label><input name="domaine" class="form-control"></div>
        </div>
        <div class="mb-3"><label class="form-label">Quota de stagiaires</label><input type="number" name="quota_stagiaires" class="form-control" value="1" min="1" required></div>
        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
        <div class="mb-3"><label class="form-label">Compétences requises</label><input name="competences_requises" class="form-control"></div>
        <button type="submit" class="btn btn-stagehub-green">Publier l'offre</button>
    </form>
</div>
@endsection
