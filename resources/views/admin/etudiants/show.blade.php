@extends('layouts.dashboard')

@section('title', $etudiant->user->name)

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'etudiants';
    $sidebarItems = [
        ['key' => 'etudiants', 'label' => 'Étudiants', 'icon' => 'bi-mortarboard', 'url' => route('admin.etudiants.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<div class="card card-stagehub p-4">
    <h4 class="fw-bold">{{ $etudiant->user->name }}</h4>
    <p class="text-muted">{{ $etudiant->niveau }} — {{ $etudiant->domaine }}</p>
    <p><strong>Email:</strong> {{ $etudiant->user->email }}</p>
    <p><strong>Département:</strong> {{ $etudiant->departement?->nom ?? '—' }}</p>
    <p><strong>Statut:</strong> <span class="badge badge-status-{{ $etudiant->statut }}">{{ $etudiant->statut }}</span></p>
    <p><strong>Compétences:</strong> {{ $etudiant->competences }}</p>

    <h6 class="fw-bold mt-4">Candidatures</h6>
    @foreach($etudiant->candidatures as $c)
        <div class="small border-bottom py-2">{{ $c->offreStage->titre }} — <span class="badge badge-status-{{ $c->statut }}">{{ $c->statut }}</span></div>
    @endforeach
</div>
@endsection
