@extends('layouts.app')
@section('title', 'Receta')
@section('page-title', 'Detalle de receta')
@section('content')
<div class="card">
    <ul class="detail-list">
        <li><strong>Paciente:</strong> {{ $receta->reporteClinico->cita->paciente->user->name }}</li>
        <li><strong>Médico:</strong> {{ $receta->reporteClinico->cita->medico->user->name }}</li>
        <li><strong>Diagnóstico:</strong> {{ $receta->reporteClinico->diagnostico }}</li>
        <li><strong>Instrucciones:</strong> {{ $receta->instrucciones_generales ?? '—' }}</li>
    </ul>
</div>
@if($receta->entregas->isNotEmpty())
<div class="card">
    <h2>Entregas realizadas</h2>
    <table class="data-table">
        <thead><tr><th>Medicamento</th><th>Cantidad</th><th>Farmacéutico</th><th>Fecha</th></tr></thead>
        <tbody>
            @foreach($receta->entregas as $e)
            <tr>
                <td>{{ $e->medicamento->nombre }}</td>
                <td>{{ $e->cantidad_entregada }}</td>
                <td>{{ $e->farmaceutico->name }}</td>
                <td>{{ $e->entregado_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@if(auth()->user()->isAdmin() || auth()->user()->isFarmaceutico())
    <a href="{{ route('entregas.create', ['receta_id' => $receta->id]) }}" class="btn btn-primary">Registrar entrega</a>
@endif
<a href="{{ route('recetas.index') }}" class="btn btn-secondary">Volver</a>
@endsection
