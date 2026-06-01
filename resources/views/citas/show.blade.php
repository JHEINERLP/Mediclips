@extends('layouts.app')
@section('title', 'Cita')
@section('page-title', 'Detalle de cita')
@section('content')
<div class="card">
    <ul class="detail-list">
        <li><strong>Fecha:</strong> {{ $cita->fecha_hora->format('d/m/Y H:i') }}</li>
        <li><strong>Paciente:</strong> {{ $cita->paciente->user->name }}</li>
        <li><strong>Médico:</strong> {{ $cita->medico->user->name }}</li>
        <li><strong>Estado:</strong> <span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></li>
        <li><strong>Motivo:</strong> {{ $cita->motivo }}</li>
    </ul>
</div>

@if(auth()->user()->isAdmin() || auth()->user()->isMedico())
<div class="card">
    <h2>Cambiar estado</h2>
    <form method="POST" action="{{ route('citas.estado', $cita) }}">
        @csrf @method('PATCH')
        <div class="form-group">
            <select name="estado">
                @foreach(['pendiente','aceptada','rechazada','cancelada','completada'] as $e)
                    <option value="{{ $e }}" @selected($cita->estado === $e)>{{ ucfirst($e) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar estado</button>
    </form>
</div>
@endif

@if(auth()->user()->isPaciente() && $cita->estado === 'pendiente')
<div class="card">
    <form method="POST" action="{{ route('citas.estado', $cita) }}">
        @csrf @method('PATCH')
        <input type="hidden" name="estado" value="cancelada">
        <button type="submit" class="btn btn-danger">Cancelar cita</button>
    </form>
</div>
@endif

@if($cita->estado === 'completada' && !$cita->reporteClinico && (auth()->user()->isAdmin() || auth()->user()->isMedico()))
    <a href="{{ route('reportes.create', ['cita_id' => $cita->id]) }}" class="btn btn-primary">Crear reporte clínico</a>
@endif

@if($cita->reporteClinico)
<div class="card">
    <h2>Reporte clínico</h2>
    <p><strong>Diagnóstico:</strong> {{ $cita->reporteClinico->diagnostico }}</p>
    <a href="{{ route('reportes.show', $cita->reporteClinico) }}" class="btn btn-sm btn-secondary">Ver reporte</a>
</div>
@endif

<div style="margin-top:16px;">
    @if(auth()->user()->isAdmin())
        <a href="{{ route('citas.edit', $cita) }}" class="btn btn-secondary">Editar</a>
    @endif
    <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
