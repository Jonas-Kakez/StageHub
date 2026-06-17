@extends('layouts.dashboard')

@section('title', 'Stagiaires')

@php
    $dashboardTitle = 'StageHub - Encadreur';
    $navColor = 'green';
    $active = 'stagiaires';
    $sidebarItems = [
        ['key' => 'stagiaires', 'label' => 'Stagiaires', 'icon' => 'bi-people', 'url' => route('encadreur.stagiaires.index'), 'activeClass' => 'active-green'],
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-file-earmark-text', 'url' => route('encadreur.rapports.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Mes stagiaires</h4>
@forelse($stagiaires as $a)
    <div class="card card-stagehub p-4 mb-3">
        <h5 class="fw-bold">{{ $a->etudiant->user->name }}</h5>
        <p class="text-muted small">{{ $a->offreStage->titre }} — {{ $a->entreprise->nom }}</p>
        <p class="small">Progression: {{ $a->progression() }}%</p>
        <div class="progress progress-stagehub mb-3"><div class="progress-bar bg-success" style="width:{{ $a->progression() }}%"></div></div>
        <a href="{{ route('encadreur.evaluations.create', $a) }}" class="btn btn-outline-primary btn-sm">Évaluer</a>
    </div>
@empty
    <div class="card card-stagehub p-4 text-muted text-center">Aucun stagiaire assigné.</div>
@endforelse
@endsection
