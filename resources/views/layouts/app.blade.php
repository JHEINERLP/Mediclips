<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - MedicClips</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="dashboard-body">
<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-brand">Medic<span>Clips</span></div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('medicos.index') }}" class="{{ request()->routeIs('medicos.*') ? 'active' : '' }}">Médicos</a>
                <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">Pacientes</a>
                <a href="{{ route('farmaceuticos.index') }}" class="{{ request()->routeIs('farmaceuticos.*') ? 'active' : '' }}">Farmacéuticos</a>
                <a href="{{ route('especialidades.index') }}" class="{{ request()->routeIs('especialidades.*') ? 'active' : '' }}">Especialidades</a>
                <a href="{{ route('horarios.index') }}" class="{{ request()->routeIs('horarios.*') ? 'active' : '' }}">Horarios</a>
                <a href="{{ route('clinica.edit') }}" class="{{ request()->routeIs('clinica.*') ? 'active' : '' }}">Mi Clínica</a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isMedico() || auth()->user()->isPaciente())
                <a href="{{ route('citas.index') }}" class="{{ request()->routeIs('citas.*') ? 'active' : '' }}">Citas</a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isMedico())
                <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'active' : '' }}">Reportes</a>
                <a href="{{ route('recetas.index') }}" class="{{ request()->routeIs('recetas.*') ? 'active' : '' }}">Recetas</a>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isFarmaceutico())
                <a href="{{ route('medicamentos.index') }}" class="{{ request()->routeIs('medicamentos.*') ? 'active' : '' }}">Medicamentos</a>
                <a href="{{ route('entregas.index') }}" class="{{ request()->routeIs('entregas.*') ? 'active' : '' }}">Entregas</a>
            @endif
        </nav>
        <div class="sidebar-footer">
            {{ auth()->user()->clinica?->nombre ?? 'Sin clínica' }}
        </div>
    </aside>

    <div class="main-content">
        <header class="topbar">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="topbar-user">
                {{ auth()->user()->name }}
                <span>({{ ucfirst(auth()->user()->rol) }})</span>
                &nbsp;|&nbsp;
                <form method="POST" action="{{ route('logout') }}" class="inline-form">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-secondary">Salir</button>
                </form>
            </div>
        </header>

        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
