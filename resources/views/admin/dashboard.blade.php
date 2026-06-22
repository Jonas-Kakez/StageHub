@extends('layouts.dashboard')

@section('title', 'Administration')

@php
    $dashboardTitle = 'Bureau de stage UDBL';
    $navColor = 'green';
    $active = 'dashboard';
    $sidebarItems = [
        ['key' => 'dashboard', 'label' => 'Vue d\'ensemble', 'icon' => 'bi-bar-chart-fill', 'url' => route('admin.dashboard'), 'activeClass' => 'active-green'],
        ['key' => 'candidatures', 'label' => 'Candidatures', 'icon' => 'bi-envelope', 'url' => route('admin.candidatures.index'), 'activeClass' => 'active-green'],
        ['key' => 'etudiants', 'label' => 'Étudiants', 'icon' => 'bi-mortarboard', 'url' => route('admin.etudiants.index'), 'activeClass' => 'active-green'],
        ['key' => 'entreprises', 'label' => 'Entreprises', 'icon' => 'bi-building', 'url' => route('admin.entreprises.index'), 'activeClass' => 'active-green'],
        ['key' => 'offres', 'label' => 'Stages', 'icon' => 'bi-briefcase', 'url' => route('admin.offres.index'), 'activeClass' => 'active-green'],
        ['key' => 'evaluations', 'label' => 'Évaluations', 'icon' => 'bi-star', 'url' => route('admin.evaluations.index'), 'activeClass' => 'active-green'],
        ['key' => 'rapports', 'label' => 'Rapports', 'icon' => 'bi-graph-up', 'url' => route('admin.rapports.index'), 'activeClass' => 'active-green'],
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
            <div class="small text-muted">Candidatures en attente: <strong>{{ $stats['candidatures_en_attente'] ?? 0 }}</strong></div>
        </div>
        <div class="card card-stagehub p-4 mt-4">
            <h6 class="fw-bold mb-3">Domaines les plus demandés</h6>
            <canvas id="statsChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stagehub p-4 mb-4">
            <h6 class="fw-bold mb-3">Étudiants par entreprise</h6>
            @foreach($statsParEntreprise ?? [] as $row)
                <div class="d-flex justify-content-between small mb-2">
                    <span>{{ $row['entreprise']?->nom ?? '—' }}</span>
                    <strong>{{ $row['total'] }}</strong>
                </div>
            @endforeach
        </div>
        <div class="card card-stagehub p-4">
            <h6 class="fw-bold mb-3">Historique des actions</h6>
            @foreach($historiqueActions ?? [] as $action)
                <div class="d-flex align-items-center gap-2 mb-2 small">
                    <i class="bi bi-clock-history text-primary"></i>
                    <span><strong>{{ $action->action }}</strong> — {{ $action->candidature?->etudiant?->user?->name ?? 'N/A' }} ({{ $action->created_at->format('d/m/Y H:i') }})</span>
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
        datasets: [{ label: 'Offres par domaine', data: {{ json_encode($chartData['candidatures']) }}, backgroundColor: '#1e40af' }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endpush
