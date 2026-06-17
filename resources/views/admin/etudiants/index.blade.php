@extends('layouts.dashboard')

@section('title', 'Étudiants')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'etudiants';
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
    <h4 class="fw-bold mb-0">Gestion des étudiants</h4>
    <form class="d-flex" method="GET">
        <input type="search" name="search" class="form-control form-control-sm" placeholder="Rechercher un étudiant..." value="{{ request('search') }}">
    </form>
</div>

@foreach($etudiants as $etu)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="fw-bold mb-1">{{ $etu->user->name }}</h5>
                <p class="text-muted small mb-1">{{ $etu->niveau }}</p>
                <p class="text-muted small mb-0">{{ $etu->user->email }}</p>
            </div>
            <span class="badge badge-status-{{ $etu->statut }}">{{ str_replace('_', ' ', ucfirst($etu->statut)) }}</span>
        </div>
        <div class="mt-3">
            <a href="{{ route('admin.etudiants.show', $etu) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye me-1"></i>Voir le profil</a>
        </div>
    </div>
@endforeach
{{ $etudiants->links() }}
@endsection
