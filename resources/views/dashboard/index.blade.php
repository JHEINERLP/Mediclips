@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Panel de control')

@section('content')
<div class="stats-grid">
    @if(auth()->user()->isAdmin())
        <div class="stat-card">
            <div class="label">Médicos</div>
            <div class="value">{{ $stats['medicos'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Pacientes</div>
            <div class="value">{{ $stats['pacientes'] }}</div>
        </div>
    @endif
    <div class="stat-card">
        <div class="label">Citas pendientes</div>
        <div class="value">{{ $stats['citas_pendientes'] }}</div>
    </div>
    @if(auth()->user()->isAdmin() || auth()->user()->isFarmaceutico())
        <div class="stat-card">
            <div class="label">Stock bajo (&lt;10)</div>
            <div class="value">{{ $stats['medicamentos_bajo_stock'] }}</div>
        </div>
    @endif
</div>

<div class="card">
    <h2>Próximas citas</h2>
    @if($proximasCitas->isEmpty())
        <p class="empty-state">No hay citas programadas.</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($proximasCitas as $cita)
                <tr>
                    <td>{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                    <td>{{ $cita->paciente->user->name }}</td>
                    <td>{{ $cita->medico->user->name }}</td>
                    <td><span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></td>
                    <td><a href="{{ route('citas.show', $cita) }}" class="btn btn-sm btn-secondary">Ver</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@if($entregasRecientes->isNotEmpty())
<div class="card">
    <h2>Entregas recientes</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Medicamento</th>
                <th>Cantidad</th>
                <th>Farmacéutico</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entregasRecientes as $entrega)
            <tr>
                <td>{{ $entrega->entregado_at->format('d/m/Y H:i') }}</td>
                <td>{{ $entrega->medicamento->nombre }}</td>
                <td>{{ $entrega->cantidad_entregada }}</td>
                <td>{{ $entrega->farmaceutico->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
