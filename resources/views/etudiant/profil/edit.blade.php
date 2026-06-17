@extends('layouts.dashboard')

@section('title', 'Mon profil')

@php
    $dashboardTitle = 'StageHub - Étudiant';
    $navColor = 'blue';
    $active = 'profil';
    $sidebarItems = [
        ['key' => 'profil', 'label' => 'Mon profil', 'icon' => 'bi-person', 'url' => route('etudiant.profil.edit'), 'activeClass' => 'active-blue'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Mon profil</h4>
<div class="card card-stagehub p-4">
    <form action="{{ route('etudiant.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3"><label class="form-label">Nom</label><input name="name" class="form-control" value="{{ auth()->user()->name }}" required></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">Niveau</label><input name="niveau" class="form-control" value="{{ $etudiant->niveau }}"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Domaine</label><input name="domaine" class="form-control" value="{{ $etudiant->domaine }}"></div>
        </div>
        <div class="mb-3"><label class="form-label">Téléphone</label><input name="telephone" class="form-control" value="{{ $etudiant->telephone }}"></div>
        <div class="mb-3"><label class="form-label">Compétences</label><textarea name="competences" class="form-control" rows="3">{{ $etudiant->competences }}</textarea></div>
        <div class="row">
            <div class="col-md-6 mb-3"><label class="form-label">CV (PDF)</label><input type="file" name="cv" class="form-control" accept=".pdf"></div>
            <div class="col-md-6 mb-3"><label class="form-label">Lettre de motivation</label><input type="file" name="lettre_motivation" class="form-control" accept=".pdf"></div>
        </div>
        <button type="submit" class="btn btn-stagehub-blue">Enregistrer</button>
    </form>
</div>
@endsection
