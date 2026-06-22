@extends('layouts.dashboard')

@section('title', 'Mes notes')

@php
    $dashboardTitle = 'StageHub UDBL - Étudiant';
    $navColor = 'blue';
    $active = 'evaluations';
    $sidebarItems = [
        ['key' => 'evaluations', 'label' => 'Mes notes', 'icon' => 'bi-star', 'url' => route('etudiant.evaluations.index'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Mes notes d'évaluation</h4>
<p class="text-muted small">Les notes sont visibles après validation par l'encadreur et le Bureau de stage UDBL.</p>
@forelse($evaluations as $e)
    <div class="card card-stagehub p-4 mb-3">
        <h5 class="fw-bold">{{ $e->affectation->offreStage->titre }}</h5>
        <p class="text-muted small">{{ $e->affectation->offreStage->entreprise->nom ?? '' }}</p>
        <div class="fs-2 fw-bold text-primary">{{ $e->note }}/20</div>
        @if($e->commentaire)<p class="mt-2">{{ $e->commentaire }}</p>@endif
        @if($e->criteres)
            <div class="small text-muted mt-2">
                @foreach($e->criteres as $k => $v)
                    @if($v){{ ucfirst($k) }}: {{ $v }}/5 &nbsp; @endif
                @endforeach
            </div>
        @endif
    </div>
@empty
    <div class="card card-stagehub p-4 text-center text-muted">Aucune note disponible pour le moment.</div>
@endforelse
@endsection
