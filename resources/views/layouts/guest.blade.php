@extends('layouts.app')

@section('body')
<nav class="navbar navbar-stagehub navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-mortarboard-fill text-primary me-2" style="color: #7c3aed !important;"></i>StageHub
        </a>
        <div class="d-flex gap-2">
            @auth
                <a href="{{ auth()->user()->dashboardRoute() }}" class="btn btn-outline-secondary btn-sm">Tableau de bord</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('profil.select') }}" class="btn btn-stagehub btn-sm">Connexion</a>
            @endauth
        </div>
    </div>
</nav>

@yield('content')
@endsection
