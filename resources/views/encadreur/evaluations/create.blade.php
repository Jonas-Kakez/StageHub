@extends('layouts.dashboard')

@section('title', 'Évaluation')

@php
    $dashboardTitle = 'StageHub - Encadreur';
    $navColor = 'green';
    $active = 'stagiaires';
    $sidebarItems = [
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('encadreur.stagiaires.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Évaluer {{ $affectation->etudiant->user->name }}</h4>
<div class="card card-stagehub p-4">
    <p class="text-muted">{{ $affectation->offreStage->titre }}</p>
    <form action="{{ route('encadreur.evaluations.store', $affectation) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Note /20</label>
            <input type="number" name="note" class="form-control" min="0" max="20" step="0.5" required>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3"><label class="form-label">Ponctualité /5</label><input type="number" name="ponctualite" class="form-control" min="0" max="5"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Compétence /5</label><input type="number" name="competence" class="form-control" min="0" max="5"></div>
            <div class="col-md-4 mb-3"><label class="form-label">Initiative /5</label><input type="number" name="initiative" class="form-control" min="0" max="5"></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Commentaire</label>
            <textarea name="commentaire" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-stagehub-green">Enregistrer l'évaluation</button>
    </form>
</div>
@endsection
