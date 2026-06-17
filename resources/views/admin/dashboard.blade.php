@extends('layouts.dashboard')

@section('title', 'Administration')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Vue d\'ensemble', 'icon' => 'bi-bar-chart-fill', 'url' => route('admin.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'etudiants', 'label' => 'Étudiants', 'icon' => 'bi-mortarboard', 'url' => route('admin.etudiants.index'), 'activeClass' => 'active-green'],
        ['key' => 'entreprises', 'label' => 'Entreprises', 'icon' => 'bi-building', 'url' => route('admin.entreprises.index'), 'activeClass' => 'active-green'],
        ['key' => 'offres', 'label' => 'Stages', 'icon' => 'bi-briefcase', 'url' => route('admin.offres.index'), 'activeClass' => 'active-green'],
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-graph-up', 'url' => route('admin.rapports.index'), 'activeClass' => 'active-green'],
        ['key' => 'users', 'label' => 'Utilisateurs', 'icon' => 'bi-people', 'url' => route('admin.users.index'), 'activeClass' => 'active-green'],
        ['key' => 'departements', 'label' => 'Départements', 'icon' => 'bi-diagram-3', 'url' => route('admin.departements.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Tableau de bord</h4>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-stagehub stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-mortarboard-fill"></i></div>
                <div>
                    <div class="text-muted small">Étudiants</div>
                    <div class="fs-4 fw-bold">{{ $stats['etudiants'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stagehub stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-building"></i></div>
                <div>
                    <div class="text-muted small">Entreprises</div>
                    <div class="fs-4 fw-bold">{{ $stats['entreprises'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-stagehub stat-card">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-briefcase-fill"></i></div>
                <div>
                    <div class="text-muted small">Stages actifs</div>
                    <div class="fs-4 fw-bold">{{ $stats['stages_actifs'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-stagehub p-4">
            <h6 class="fw-bold mb-3">Performance</h6>
            <div class="mb-2 small">Taux de placement: <strong>{{ $stats['taux_placement'] }}%</strong></div>
            <div class="progress mb-3" style="height:8px;">
                <div class="progress-bar bg-success" style="width:{{ $stats['taux_placement'] }}%"></div>
            </div>
            <div class="small text-muted">Stages complétés: <strong>{{ $stats['stages_completes'] }}</strong></div>
        </div>
        <div class="card card-stagehub p-4 mt-4">
            <h6 class="fw-bold mb-3">Statistiques</h6>
            <canvas id="statsChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stagehub p-4">
            <h6 class="fw-bold mb-3">Actions récentes</h6>
            @foreach($recentEntreprises->take(3) as $e)
                <div class="d-flex align-items-center gap-2 mb-3 small">
                    <i class="bi bi-building text-primary"></i>
                    <span>Nouvelle entreprise — {{ $e->nom }}</span>
                </div>
            @endforeach
            @foreach($recentEtudiants->take(3) as $e)
                <div class="d-flex align-items-center gap-2 mb-3 small">
                    <i class="bi bi-person-fill text-success"></i>
                    <span>Nouvelle inscription — {{ $e->user->name }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('statsChart'), {
    type: 'bar',
    data: {
        labels: {{ json_encode($chartData['labels']) }},
        datasets: [
            { label: 'Candidatures', data: {{ json_encode($chartData['candidatures']) }}, backgroundColor: '#7c3aed' },
            { label: 'Affectations', data: {{ json_encode($chartData['affectations']) }}, backgroundColor: '#16a34a' }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
