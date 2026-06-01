@extends('layouts.app')
@section('title', 'Nueva receta')
@section('page-title', 'Crear receta')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('recetas.store') }}">
        @csrf
        <div class="form-group">
            <label>Reporte clínico</label>
            <select name="reporte_clinico_id" required>
                <option value="">Seleccionar...</option>
                @foreach($reportes as $r)
                    <option value="{{ $r->id }}" @selected(old('reporte_clinico_id', $reporte?->id) == $r->id)>
                        {{ $r->cita->paciente->user->name }} — {{ Str::limit($r->diagnostico, 30) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Instrucciones generales</label><textarea name="instrucciones_generales">{{ old('instrucciones_generales') }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('recetas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
