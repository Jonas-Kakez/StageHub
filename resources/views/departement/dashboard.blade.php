@extends('layouts.dashboard')

@section('title', 'Département')

@php
    $dashboardTitle = 'StageHub - Département';
    $navColor = 'green';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-speedometer2', 'url' => route('departement.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'affectations', 'label' => 'Affectations', 'icon' => 'bi-people', 'url' => route('departement.affectations.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Tableau de bord département</h4>
@if($departement)
    <p class="text-muted">{{ $departement->nom }} — {{ $departement->faculte }}</p>
@endif
<div class="row g-3">
    <div class="col-md-4"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['etudiants'] }}</div><div class="small text-muted">Étudiants</div></div></div>
    <div class="col-md-4"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['encadreurs'] }}</div><div class="small text-muted">Encadreurs</div></div></div>
    <div class="col-md-4"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['stages_actifs'] }}</div><div class="small text-muted">Stages actifs</div></div></div>
</div>
@endsection
