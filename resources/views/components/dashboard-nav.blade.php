<nav class="navbar navbar-stagehub navbar-expand-lg">
    <div class="container">
        <a href="{{ route('home') }}" class="text-muted small me-3"><i class="bi bi-arrow-left"></i> Retour</a>
        <a class="navbar-brand fw-bold" href="#">
            @if(($color ?? '') === 'purple')
                <i class="bi bi-building me-2" style="color:#7c3aed;"></i>
            @elseif(($color ?? '') === 'green')
                <i class="bi bi-people-fill text-success me-2"></i>
            @else
                <i class="bi bi-mortarboard-fill text-primary me-2"></i>
            @endif
            {{ $title }}
        </a>
        <div class="d-flex align-items-center gap-3">
            @php $unread = auth()->user()->appNotifications()->where('lu', false)->count(); @endphp
            <a href="{{ route('notifications.index') }}" class="text-muted position-relative">
                <i class="bi bi-bell"></i>
                @if($unread > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">{{ $unread }}</span>
                @endif
            </a>
            <span class="text-muted small">{{ auth()->user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>
