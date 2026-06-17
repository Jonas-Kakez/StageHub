@extends('layouts.dashboard')

@section('title', 'Rapports')

@php
    $dashboardTitle = 'StageHub - Encadreur';
    $navColor = 'green';
    $active = 'rapports';
    $sidebarItems = [
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-file-earmark-text', 'url' => route('encadreur.rapports.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Rapports de stage</h4>
@forelse($rapports as $r)
    <div class="card card-stagehub p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="fw-bold">{{ $r->titre }}</h5>
                <p class="text-muted small">{{ $r->etudiant->user->name }} — {{ $r->created_at->format('d/m/Y') }}</p>
            </div>
            <span class="badge badge-status-{{ $r->statut }}">{{ $r->statut }}</span>
        </div>
        <div class="d-flex gap-2 mt-2">
            <a href="{{ route('encadreur.rapports.download', $r) }}" class="btn btn-outline-secondary btn-sm">Télécharger</a>
            <form action="{{ route('encadreur.rapports.commenter', $r) }}" method="POST" class="d-flex gap-2 flex-grow-1">
                @csrf
                <select name="statut" class="form-select form-select-sm">
                    <option value="en_revision">En révision</option>
                    <option value="approuve">Approuvé</option>
                    <option value="refuse">Refusé</option>
                </select>
                <input name="commentaire_encadreur" class="form-control form-control-sm" placeholder="Commentaire">
                <button class="btn btn-sm btn-success">Soumettre</button>
            </form>
        </div>
    </div>
@empty
    <div class="card card-stagehub p-4 text-muted text-center">Aucun rapport.</div>
@endforelse
@endsection
