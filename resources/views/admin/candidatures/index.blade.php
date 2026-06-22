@extends('layouts.dashboard')

@section('title', 'Candidatures')

@php
    $dashboardTitle = 'Bureau de stage UDBL';
    $navColor = 'green';
    $active = 'candidatures';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Vue d\'ensemble', 'icon' => 'bi-bar-chart-fill', 'url' => route('admin.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-envelope', 'url' => route('admin.candidatures.index'), 'activeClass' => 'active-green'],
        ['key' => 'offres', 'label' => 'Stages', 'icon' => 'bi-briefcase', 'url' => route('admin.offres.index'), 'activeClass' => 'active-green'],
        ['key' => 'evaluations', 'label' => 'Évaluations', 'icon' => 'bi-star', 'url' => route('admin.evaluations.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Candidatures à traiter</h4>
@foreach($candidatures as $c)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="fw-bold">{{ $c->etudiant->user->name }}</h5>
                <p class="text-muted small">{{ $c->offreStage->titre }} — {{ $c->offreStage->entreprise->nom }}</p>
                <p class="text-muted small">{{ $c->etudiant->niveau }} — {{ $c->created_at->format('d/m/Y') }}</p>
            </div>
            <span class="badge badge-status-{{ $c->statut }}">{{ str_replace('_', ' ', ucfirst($c->statut)) }}</span>
        </div>
        @if($c->statut === 'en_attente')
            <div class="d-flex gap-2 mt-3">
                <form action="{{ route('admin.candidatures.transmettre', $c) }}" method="POST">@csrf<button class="btn btn-success btn-sm">Transmettre à l'entreprise</button></form>
                <form action="{{ route('admin.candidatures.refuser', $c) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="motif_refus" class="form-control form-control-sm" placeholder="Motif" required>
                    <button class="btn btn-danger btn-sm">Refuser</button>
                </form>
            </div>
        @endif
    </div>
@endforeach
{{ $candidatures->links() }}
@endsection
