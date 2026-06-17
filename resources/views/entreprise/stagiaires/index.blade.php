@extends('layouts.dashboard')

@section('title', 'Stagiaires')

@php
    $dashboardTitle = 'StageHub - Entreprise';
    $navColor = 'purple';
    $active = 'stagiaires';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Mes offres', 'icon' => 'bi-briefcase', 'url' => route('entreprise.offres.index')],
        ['key' => 'create', 'label' => 'Publier une offre', 'icon' => 'bi-plus-lg', 'url' => route('entreprise.offres.create')],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-file-earmark-text', 'url' => route('entreprise.candidatures.index')],
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('entreprise.stagiaires.index')],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Stagiaires en cours</h4>
<div class="row g-3">
    @forelse($stagiaires as $a)
        <div class="col-md-6">
            <div class="card card-stagehub p-4">
                <h5 class="fw-bold">{{ $a->etudiant->user->name }}</h5>
                <p class="text-muted small">{{ $a->offreStage->titre }}</p>
                <div class="small text-muted mb-2">
                    <i class="bi bi-calendar me-1"></i>Début: {{ $a->date_debut?->format('d/m/Y') }}
                    — Fin: {{ $a->date_fin?->format('d/m/Y') }}
                </div>
                <div class="mb-2 small">Progression: {{ $a->progression() }}%</div>
                <div class="progress progress-stagehub mb-3"><div class="progress-bar" style="width:{{ $a->progression() }}%"></div></div>
                <form action="{{ route('entreprise.stagiaires.evaluer', $a) }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-4"><input type="number" name="note" class="form-control form-control-sm" placeholder="Note /20" min="0" max="20" step="0.5" required></div>
                    <div class="col-6"><input type="text" name="commentaire" class="form-control form-control-sm" placeholder="Commentaire"></div>
                    <div class="col-2"><button class="btn btn-outline-primary btn-sm w-100">Évaluer</button></div>
                </form>
            </div>
        </div>
    @empty
        <div class="col-12"><div class="card card-stagehub p-4 text-muted text-center">Aucun stagiaire actif.</div></div>
    @endforelse
</div>

<h5 class="fw-bold mt-5 mb-3">Affecter un candidat accepté</h5>
@php $accepted = \App\Models\Candidature::whereIn('offre_stage_id', auth()->user()->entreprise->offresStage()->pluck('id'))->where('statut','acceptee')->whereDoesntHave('affectation')->with('etudiant.user','offreStage')->get(); @endphp
@foreach($accepted as $c)
    <div class="card card-stagehub p-3 mb-2">
        <strong>{{ $c->etudiant->user->name }}</strong> — {{ $c->offreStage->titre }}
        <form action="{{ route('entreprise.stagiaires.affecter', $c) }}" method="POST" class="row g-2 mt-2">
            @csrf
            <div class="col-md-4"><input type="date" name="date_debut" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><input type="date" name="date_fin" class="form-control form-control-sm" required></div>
            <div class="col-md-4"><button class="btn btn-stagehub btn-sm w-100">Affecter</button></div>
        </form>
    </div>
@endforeach
@endsection
