@extends('layouts.dashboard')

@section('title', 'Rapports')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'rapports';
    $sidebarItems = [
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-graph-up', 'url' => route('admin.rapports.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Rapports de stage</h4>
@foreach($rapports as $r)
    <div class="card card-stagehub p-3 mb-2 d-flex justify-content-between align-items-center">
        <div>
            <strong>{{ $r->titre }}</strong>
            <div class="small text-muted">{{ $r->etudiant->user->name }} — {{ $r->created_at->format('d/m/Y') }}</div>
        </div>
        <span class="badge badge-status-{{ $r->statut }}">{{ $r->statut }}</span>
    </div>
@endforeach
{{ $rapports->links() }}
@endsection
