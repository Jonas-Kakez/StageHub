@extends('layouts.dashboard')

@section('title', 'Entreprises')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'entreprises';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Vue d\'ensemble', 'icon' => 'bi-bar-chart-fill', 'url' => route('admin.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'etudiants', 'label' => 'Étudiants', 'icon' => 'bi-mortarboard', 'url' => route('admin.etudiants.index'), 'activeClass' => 'active-green'],
        ['key' => 'entreprises', 'label' => 'Entreprises', 'icon' => 'bi-building', 'url' => route('admin.entreprises.index'), 'activeClass' => 'active-green'],
        ['key' => 'offres', 'label' => 'Stages', 'icon' => 'bi-briefcase', 'url' => route('admin.offres.index'), 'activeClass' => 'active-green'],
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-graph-up', 'url' => route('admin.rapports.index'), 'activeClass' => 'active-green'],
        ['key' => 'users', 'label' => 'Utilisateurs', 'icon' => 'bi-people', 'url' => route('admin.users.index'), 'activeClass' => 'active-green'],
        ['key' => 'departements', 'label' => 'Départements', 'icon' => 'bi-diagram-3', 'url' => route('admin.departements.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Gestion des entreprises</h4>
    <form class="d-flex" method="GET">
        <input type="search" name="search" class="form-control form-control-sm" placeholder="Rechercher une entreprise..." value="{{ request('search') }}">
    </form>
</div>

@foreach($entreprises as $e)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="fw-bold">{{ $e->nom }}</h5>
                <p class="text-muted small">{{ $e->secteur }}</p>
                <p class="text-muted small"><i class="bi bi-envelope me-1"></i>{{ $e->user->email }}</p>
                <p class="text-muted small">{{ $e->offres_stage_count }} offre(s) active(s)</p>
            </div>
            <span class="badge badge-status-{{ $e->statut_validation }}">{{ ucfirst($e->statut_validation) }}</span>
        </div>
        <a href="{{ route('admin.entreprises.show', $e) }}" class="btn btn-outline-secondary btn-sm mt-2"><i class="bi bi-eye me-1"></i>Voir les détails</a>
    </div>
@endforeach
{{ $entreprises->links() }}
@endsection
