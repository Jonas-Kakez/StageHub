@extends('layouts.dashboard')

@section('title', 'Candidatures')

@php
    $dashboardTitle = 'StageHub - Entreprise';
    $navColor = 'purple';
    $active = 'candidatures';
    $sidebarItems = [
        ['key' => 'offres', 'label' => 'Mes offres', 'icon' => 'bi-briefcase', 'url' => route('entreprise.offres.index')],
        ['key' => 'create', 'label' => 'Publier une offre', 'icon' => 'bi-plus-lg', 'url' => route('entreprise.offres.create')],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-file-earmark-text', 'url' => route('entreprise.candidatures.index')],
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('entreprise.stagiaires.index')],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Candidatures reçues</h4>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-4 fw-bold">{{ $stats['total'] }}</div><div class="small text-muted">Total</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-4 fw-bold">{{ $stats['transmises'] }}</div><div class="small text-muted">Transmises UDBL</div></div></div>
    <div class="col-md-3"><div class="card card-stagehub stat-card text-center"><div class="fs-4 fw-bold">{{ $stats['acceptees'] }}</div><div class="small text-muted">Acceptées</div></div></div>
</div>
@foreach($candidatures as $c)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="fw-bold">{{ $c->etudiant->user->name }}</h5>
                <p class="text-muted small mb-1">{{ $c->offreStage->titre }}</p>
                <p class="text-muted small mb-1">{{ $c->etudiant->niveau }}</p>
                <p class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $c->etudiant->user->email }}</p>
                <p class="text-muted small"><i class="bi bi-calendar me-1"></i>Candidature du {{ $c->created_at->format('d/m/Y') }}</p>
            </div>
            <span class="badge badge-status-{{ $c->statut }}">{{ str_replace('_', ' ', ucfirst($c->statut)) }}</span>
        </div>
        @if($c->statut === 'transmise')
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('entreprise.candidatures.cv', $c) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye me-1"></i>Voir CV</a>
                <form action="{{ route('entreprise.candidatures.accepter', $c) }}" method="POST">@csrf<button class="btn btn-success btn-sm"><i class="bi bi-check me-1"></i>Accepter</button></form>
                <form action="{{ route('entreprise.candidatures.refuser', $c) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="motif_refus" class="form-control form-control-sm" placeholder="Motif">
                    <button class="btn btn-danger btn-sm"><i class="bi bi-x"></i>Refuser</button>
                </form>
            </div>
        @endif
    </div>
@endforeach
@endsection
