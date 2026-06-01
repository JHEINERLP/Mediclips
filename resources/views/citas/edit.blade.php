@extends('layouts.app')
@section('title', 'Editar cita')
@section('page-title', 'Editar cita')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('citas.update', $cita) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Paciente</label>
            <select name="paciente_id" required>
                @foreach($pacientes as $p)
                    <option value="{{ $p->id }}" @selected(old('paciente_id', $cita->paciente_id) == $p->id)>{{ $p->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Médico</label>
            <select name="medico_id" required>
                @foreach($medicos as $m)
                    <option value="{{ $m->id }}" @selected(old('medico_id', $cita->medico_id) == $m->id)>{{ $m->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Fecha y hora</label><input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora', $cita->fecha_hora->format('Y-m-d\TH:i')) }}" required></div>
        <div class="form-group"><label>Motivo</label><textarea name="motivo" required>{{ old('motivo', $cita->motivo) }}</textarea></div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado" required>
                @foreach(['pendiente','aceptada','rechazada','cancelada','completada'] as $e)
                    <option value="{{ $e }}" @selected(old('estado', $cita->estado) === $e)>{{ ucfirst($e) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
