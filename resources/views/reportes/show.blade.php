@extends('layouts.app')
@section('title', 'Reporte clínico')
@section('page-title', 'Detalle del reporte')
@section('content')
<div class="card">
    <ul class="detail-list">
        <li><strong>Paciente:</strong> {{ $reporte->cita->paciente->user->name }}</li>
        <li><strong>Médico:</strong> {{ $reporte->cita->medico->user->name }}</li>
        <li><strong>Fecha cita:</strong> {{ $reporte->cita->fecha_hora->format('d/m/Y H:i') }}</li>
        <li><strong>Diagnóstico:</strong> {{ $reporte->diagnostico }}</li>
        <li><strong>Plan tratamiento:</strong> {{ $reporte->plan_tratamiento }}</li>
    </ul>
</div>
@if(!$reporte->receta)
    <a href="{{ route('recetas.create', ['reporte_id' => $reporte->id]) }}" class="btn btn-primary">Crear receta</a>
@else
    <a href="{{ route('recetas.show', $reporte->receta) }}" class="btn btn-primary">Ver receta</a>
@endif
<a href="{{ route('reportes.edit', $reporte) }}" class="btn btn-secondary">Editar</a>
<a href="{{ route('reportes.index') }}" class="btn btn-secondary">Volver</a>
@endsection
