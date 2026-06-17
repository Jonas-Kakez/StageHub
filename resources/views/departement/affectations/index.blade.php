@extends('layouts.dashboard')

@section('title', 'Affectations')

@php
    $dashboardTitle = 'StageHub - Département';
    $navColor = 'green';
    $active = 'affectations';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-speedometer2', 'url' => route('departement.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'affectations', 'label' => 'Affectations', 'icon' => 'bi-people', 'url' => route('departement.affectations.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Attribution des encadreurs</h4>
@foreach($affectations as $a)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold">{{ $a->etudiant->user->name }}</h5>
                <p class="text-muted small">{{ $a->offreStage->titre }} — {{ $a->entreprise->nom }}</p>
                <p class="text-muted small">Encadreur: {{ $a->encadreur?->user?->name ?? 'Non assigné' }}</p>
            </div>
            <form action="{{ route('departement.affectations.encadreur', $a) }}" method="POST" class="d-flex gap-2">
                @csrf
                <select name="encadreur_id" class="form-select form-select-sm" required>
                    <option value="">Choisir encadreur</option>
                    @foreach($encadreurs as $enc)
                        <option value="{{ $enc->id }}" {{ $a->encadreur_id == $enc->id ? 'selected' : '' }}>{{ $enc->user->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-stagehub-green btn-sm">Assigner</button>
            </form>
        </div>
    </div>
@endforeach
{{ $affectations->links() }}
@endsection
