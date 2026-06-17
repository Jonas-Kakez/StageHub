@extends('layouts.dashboard')

@section('title', 'Notifications')

@php
    $dashboardTitle = 'StageHub';
    $active = 'notifications';
    $sidebarItems = [];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Notifications</h4>
<div class="card card-stagehub">
    <div class="list-group list-group-flush">
        @forelse($notifications as $n)
            <div class="list-group-item d-flex justify-content-between align-items-start {{ $n->lu ? '' : 'bg-light' }}">
                <div>
                    <div class="fw-semibold">{{ $n->titre }}</div>
                    <div class="small text-muted">{{ $n->message }}</div>
                    <div class="small text-muted">{{ $n->created_at->format('d/m/Y H:i') }}</div>
                </div>
                @if($n->lien)
                    <form action="{{ route('notifications.read', $n) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">Voir</button>
                    </form>
                @endif
            </div>
        @empty
            <div class="list-group-item text-muted text-center">Aucune notification.</div>
        @endforelse
    </div>
</div>
<form action="{{ route('notifications.read-all') }}" method="POST" class="mt-3">
    @csrf
    <button class="btn btn-outline-secondary btn-sm">Marquer tout comme lu</button>
</form>
@endsection
