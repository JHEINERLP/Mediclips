@extends('layouts.app')
@section('title', 'Entregas')
@section('page-title', 'Entregas de medicamentos')
@section('content')
<div class="page-header">
    <h2>Entregas</h2>
    <a href="{{ route('entregas.create') }}" class="btn btn-primary">Nueva entrega</a>
</div>
<div class="card">
    @if($entregas->isEmpty())
        <p class="empty-state">No hay entregas registradas.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Fecha</th><th>Paciente</th><th>Medicamento</th><th>Cantidad</th><th>Farmacéutico</th><th></th></tr></thead>
        <tbody>
            @foreach($entregas as $e)
            <tr>
                <td>{{ $e->entregado_at->format('d/m/Y H:i') }}</td>
                <td>{{ $e->receta->reporteClinico->cita->paciente->user->name }}</td>
                <td>{{ $e->medicamento->nombre }}</td>
                <td>{{ $e->cantidad_entregada }}</td>
                <td>{{ $e->farmaceutico->name }}</td>
                <td><a href="{{ route('entregas.show', $e) }}" class="btn btn-sm btn-secondary">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
