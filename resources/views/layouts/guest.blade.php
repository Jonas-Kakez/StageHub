@extends('layouts.app')

@section('body')
<nav class="navbar navbar-stagehub navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/udbl-logo.png') }}" alt="UDBL" class="udbl-logo">
            <span class="d-none d-md-inline text-udbl">StageHub <small class="text-muted fw-normal">| UDBL</small></span>
        </a>
        <div class="d-flex gap-2">
            @auth
                <a href="{{ auth()->user()->dashboardRoute() }}" class="btn btn-outline-primary btn-sm">Tableau de bord</a>
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

<footer class="udbl-footer text-center">
    <div class="container">
        <strong>Université Don Bosco de Lubumbashi (UDBL)</strong><br>
        <span class="opacity-75">Solidarité — Innovation — Travail</span>
    </div>
</footer>
@endsection
