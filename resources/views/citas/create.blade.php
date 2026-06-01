@extends('layouts.app')
@section('title', 'Agendar cita')
@section('page-title', 'Agendar cita')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('citas.store') }}">
        @csrf
        @php($pacienteId = auth()->user()->paciente?->id)
        @if($pacienteId)
            <input type="hidden" name="paciente_id" value="{{ $pacienteId }}">
        @else
            <div class="form-group">
                <label>Paciente</label>
                <select name="paciente_id" required>
                    <option value="">Seleccionar...</option>
                    @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" @selected(old('paciente_id') == $p->id)>{{ $p->user->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="form-group">
            <label>Médico</label>
            <select name="medico_id" required>
                <option value="">Seleccionar...</option>
                @foreach($medicos as $m)
                    <option value="{{ $m->id }}" @selected(old('medico_id') == $m->id)>{{ $m->user->name }} — {{ $m->especialidad->nombre ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Fecha y hora</label><input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora') }}" required></div>
        <div class="form-group"><label>Motivo</label><textarea name="motivo" required>{{ old('motivo') }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Agendar</button>
            <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
