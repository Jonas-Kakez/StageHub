@extends('layouts.dashboard')

@section('title', 'Utilisateurs')

@php
    $dashboardTitle = 'StageHub - Administration';
    $navColor = 'green';
    $active = 'users';
    $sidebarItems = [
        ['key' => 'users', 'label' => 'Utilisateurs', 'icon' => 'bi-people', 'url' => route('admin.users.index'), 'activeClass' => 'active-green'],
    ];
@endphp

@section('dashboard-content')
<h4 class="fw-bold mb-4">Gestion des utilisateurs</h4>
<div class="card card-stagehub">
    <table class="table table-hover mb-0">
        <thead><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Actif</th><th></th></tr></thead>
        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
                    <td>{{ $u->is_active ? 'Oui' : 'Non' }}</td>
                    <td>
                        <form action="{{ route('admin.users.toggle', $u) }}" method="POST">@csrf
                            <button class="btn btn-sm btn-outline-secondary">Toggle</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->links() }}
@endsection
