@extends('layouts.dashboard')

@section('title', 'Évaluations')

@php
    $dashboardTitle = 'Bureau de stage UDBL';
    $navColor = 'green';
    $active = 'evaluations';
    $sidebarItems = [
        ['key' => 'evaluations', 'label' => 'Évaluations', 'icon' => 'bi-star', 'url' => route('admin.evaluations.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Évaluations à valider</h4>
@foreach($evaluations as $e)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="fw-bold">{{ $e->affectation->etudiant->user->name }}</h5>
                <p class="text-muted small">{{ $e->affectation->offreStage->titre }}</p>
                <p class="mb-0"><strong>Note :</strong> {{ $e->note }}/20</p>
                <p class="small text-muted">{{ $e->commentaire }}</p>
            </div>
            <div>
                @if($e->validee_institution)
                    <span class="badge bg-success">Validée</span>
                @else
                    <form action="{{ route('admin.evaluations.valider', $e) }}" method="POST">@csrf<button class="btn btn-success btn-sm">Valider pour l'étudiant</button></form>
                @endif
            </div>
        </div>
    </div>
@endforeach
{{ $evaluations->links() }}
@endsection
