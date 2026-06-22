@extends('layouts.dashboard')

@section('title', 'Modération offres')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'offres';
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
<h4 class="fw-bold mb-4">Modération des offres</h4>
<div class="mb-3"><a href="{{ route('admin.offres.create') }}" class="btn btn-stagehub-green btn-sm">+ Publier pour une entreprise</a></div>
@foreach($offres as $offre)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="fw-bold">{{ $offre->titre }}</h5>
                <p class="text-muted small">{{ $offre->entreprise->nom }} — {{ $offre->localisation }}</p>
            </div>
            <span class="badge badge-status-{{ $offre->statut }}">{{ $offre->statut }}</span>
        </div>
        @if($offre->statut === 'en_attente')
            <div class="d-flex gap-2 mt-3">
                <form action="{{ route('admin.offres.approuver', $offre) }}" method="POST">@csrf<button class="btn btn-success btn-sm">Approuver</button></form>
                <form action="{{ route('admin.offres.refuser', $offre) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="motif_refus" class="form-control form-control-sm" placeholder="Motif" required>
                    <button class="btn btn-danger btn-sm">Refuser</button>
                </form>
            </div>
        @elseif($offre->statut === 'active')
            <form action="{{ route('admin.offres.desactiver', $offre) }}" method="POST" class="mt-2">@csrf<button class="btn btn-outline-danger btn-sm">Désactiver</button></form>
        @endif
    </div>
@endforeach
{{ $offres->links() }}
@endsection
