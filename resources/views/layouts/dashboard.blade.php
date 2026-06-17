@extends('layouts.app')

@section('body')
@include('components.dashboard-nav', ['title' => $dashboardTitle ?? 'StageHub', 'color' => $navColor ?? 'primary'])

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card card-stagehub p-3">
                <nav class="sidebar-nav nav flex-column">
                    @foreach($sidebarItems ?? [] as $item)
                        <a class="nav-link {{ ($active ?? '') === $item['key'] ? ($item['activeClass'] ?? 'active') : '' }}"
                           href="{{ $item['url'] }}">
                            <i class="bi {{ $item['icon'] }} me-2"></i>{{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
        <div class="col-lg-9">
            @yield('dashboard-content')
        </div>
    </div>
</div>
@endsection
