@extends('layouts.dashboard')

@section('title', $entreprise->nom)

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'entreprises';
    $sidebarItems = [
        ['key' => 'entreprises', 'label' => 'Entreprises', 'icon' => 'bi-building', 'url' => route('admin.entreprises.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<div class="card card-stagehub p-4">
    <h4 class="fw-bold">{{ $entreprise->nom }}</h4>
    <p class="text-muted">{{ $entreprise->secteur }}</p>
    <p><strong>Email:</strong> {{ $entreprise->user->email }}</p>
    <p><strong>Localisation:</strong> {{ $entreprise->localisationComplete() }}</p>
  @if($entreprise->latitude && $entreprise->longitude)
        <p><strong>Coordonnées:</strong> {{ $entreprise->latitude }}, {{ $entreprise->longitude }}</p>
    @endif
    <p><strong>Statut:</strong> <span class="badge badge-status-{{ $entreprise->statut_validation }}">{{ $entreprise->statut_validation }}</span></p>

    @if($entreprise->statut_validation === 'en_attente')
        <div class="d-flex gap-2 mt-3">
            <form action="{{ route('admin.entreprises.valider', $entreprise) }}" method="POST">@csrf<button class="btn btn-success btn-sm">Valider</button></form>
            <form action="{{ route('admin.entreprises.refuser', $entreprise) }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="text" name="motif_refus" class="form-control form-control-sm" placeholder="Motif du refus" required>
                <button class="btn btn-danger btn-sm">Refuser</button>
            </form>
        </div>
    @endif

    <h6 class="fw-bold mt-4">Offres de stage</h6>
    @foreach($entreprise->offresStage as $o)
        <div class="small border-bottom py-2">{{ $o->titre }} — {{ $o->statut }}</div>
    @endforeach
</div>
@endsection
