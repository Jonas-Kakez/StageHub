@extends('layouts.dashboard')

@section('title', 'Départements')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'departements';
    $sidebarItems = [
        ['key' => 'departements', 'label' => 'Départements', 'icon' => 'bi-diagram-3', 'url' => route('admin.departements.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Départements et encadreurs</h4>

<div class="card card-stagehub p-4 mb-4">
    <h6 class="fw-bold">Nouveau département</h6>
    <form action="{{ route('admin.departements.store') }}" method="POST" class="row g-2">
        @csrf
        <div class="col-md-4"><input name="nom" class="form-control" placeholder="Nom" required></div>
        <div class="col-md-4"><input name="faculte" class="form-control" placeholder="Faculté"></div>
        <div class="col-md-4"><button class="btn btn-stagehub-green w-100">Créer</button></div>
    </form>
</div>

@foreach($departements as $d)
    <div class="card card-stagehub p-4 mb-3">
        <h5 class="fw-bold">{{ $d->nom }} <span class="text-muted small">({{ $d->faculte }})</span></h5>
        <p class="text-muted small">{{ $d->etudiants_count }} étudiants — {{ $d->encadreurs_count }} encadreurs</p>
        <form action="{{ route('admin.departements.encadreurs.store', $d) }}" method="POST" class="row g-2 mt-2">
            @csrf
            <div class="col-md-3"><input name="name" class="form-control form-control-sm" placeholder="Nom encadreur" required></div>
            <div class="col-md-3"><input name="email" type="email" class="form-control form-control-sm" placeholder="Email" required></div>
            <div class="col-md-2"><input name="password" type="password" class="form-control form-control-sm" placeholder="Mot de passe" required></div>
            <div class="col-md-2"><input name="specialite" class="form-control form-control-sm" placeholder="Spécialité"></div>
            <div class="col-md-2"><button class="btn btn-sm btn-outline-primary w-100">+ Encadreur</button></div>
        </form>
    </div>
@endforeach
@endsection
