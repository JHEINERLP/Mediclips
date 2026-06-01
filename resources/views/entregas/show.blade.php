@extends('layouts.app')
@section('title', 'Entrega')
@section('page-title', 'Detalle de entrega')
@section('content')
<div class="card">
    <ul class="detail-list">
        <li><strong>Paciente:</strong> {{ $entrega->receta->reporteClinico->cita->paciente->user->name }}</li>
        <li><strong>Medicamento:</strong> {{ $entrega->medicamento->nombre }}</li>
        <li><strong>Cantidad:</strong> {{ $entrega->cantidad_entregada }}</li>
        <li><strong>Farmacéutico:</strong> {{ $entrega->farmaceutico->name }}</li>
        <li><strong>Fecha:</strong> {{ $entrega->entregado_at->format('d/m/Y H:i') }}</li>
    </ul>
</div>
<a href="{{ route('entregas.index') }}" class="btn btn-secondary">Volver</a>
@endsection
