<nav class="navbar navbar-stagehub navbar-expand-lg">
    <div class="container">
        <a href="{{ route('home') }}" class="text-muted small me-2"><i class="bi bi-arrow-left"></i> Retour</a>
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('images/udbl-logo.png') }}" alt="UDBL" class="udbl-logo" style="height:32px;">
            <span>{{ $title }}</span>
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
