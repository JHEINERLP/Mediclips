@extends('layouts.app')
@section('title', 'Editar reporte')
@section('page-title', 'Editar reporte clínico')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('reportes.update', $reporte) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Diagnóstico</label><textarea name="diagnostico" required>{{ old('diagnostico', $reporte->diagnostico) }}</textarea></div>
        <div class="form-group"><label>Plan de tratamiento</label><textarea name="plan_tratamiento" required>{{ old('plan_tratamiento', $reporte->plan_tratamiento) }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('reportes.show', $reporte) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
