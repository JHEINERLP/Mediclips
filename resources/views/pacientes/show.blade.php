@extends('layouts.app')
@section('title', $paciente->user->name)
@section('page-title', 'Detalle del paciente')
@section('content')
<div class="card">
    <ul class="detail-list">
        <li><strong>Nombre:</strong> {{ $paciente->user->name }}</li>
        <li><strong>Email:</strong> {{ $paciente->user->email }}</li>
        <li><strong>Fecha nacimiento:</strong> {{ $paciente->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</li>
        <li><strong>Género:</strong> {{ $paciente->genero ? ucfirst($paciente->genero) : '—' }}</li>
        <li><strong>Grupo sanguíneo:</strong> {{ $paciente->grupo_sanguineo ?? '—' }}</li>
        <li><strong>Emergencia:</strong> {{ $paciente->contacto_emergencia ?? '—' }}</li>
    </ul>
</div>
@if($paciente->citas->isNotEmpty())
<div class="card">
    <h2>Citas</h2>
    <table class="data-table">
        <thead><tr><th>Fecha</th><th>Médico</th><th>Estado</th></tr></thead>
        <tbody>
            @foreach($paciente->citas as $cita)
            <tr>
                <td>{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                <td>{{ $cita->medico->user->name }}</td>
                <td><span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
