@extends('layouts.app')
@section('title', 'Nuevo reporte')
@section('page-title', 'Crear reporte clínico')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('reportes.store') }}">
        @csrf
        <div class="form-group">
            <label>Cita completada</label>
            <select name="cita_id" required>
                <option value="">Seleccionar...</option>
                @foreach($citas as $c)
                    <option value="{{ $c->id }}" @selected(old('cita_id', $cita?->id) == $c->id)>
                        {{ $c->fecha_hora->format('d/m/Y') }} — {{ $c->paciente->user->name }} / {{ $c->medico->user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Diagnóstico</label><textarea name="diagnostico" required>{{ old('diagnostico') }}</textarea></div>
        <div class="form-group"><label>Plan de tratamiento</label><textarea name="plan_tratamiento" required>{{ old('plan_tratamiento') }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('reportes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
