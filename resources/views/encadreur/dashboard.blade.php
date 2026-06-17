@extends('layouts.dashboard')

@section('title', 'Encadreur')

@php
    $dashboardTitle = 'StageHub - Encadreur';
    $navColor = 'green';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-speedometer2', 'url' => route('encadreur.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('encadreur.stagiaires.index'), 'activeClass' => 'active-green'],
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-file-earmark-text', 'url' => route('encadreur.rapports.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Tableau de bord encadreur</h4>
<div class="row g-3">
    <div class="col-md-4"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['stagiaires'] }}</div><div class="small text-muted">Stagiaires</div></div></div>
    <div class="col-md-4"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['rapports'] }}</div><div class="small text-muted">Rapports</div></div></div>
    <div class="col-md-4"><div class="card card-stagehub stat-card text-center"><div class="fs-3 fw-bold">{{ $stats['evaluations'] }}</div><div class="small text-muted">Évaluations</div></div></div>
</div>
@endsection
