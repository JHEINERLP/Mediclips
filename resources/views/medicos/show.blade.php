@extends('layouts.app')
@section('title', $medico->user->name)
@section('page-title', 'Detalle del médico')
@section('content')
<div class="card">
    <ul class="detail-list">
        <li><strong>Nombre:</strong> {{ $medico->user->name }}</li>
        <li><strong>Email:</strong> {{ $medico->user->email }}</li>
        <li><strong>Especialidad:</strong> {{ $medico->especialidad->nombre }}</li>
        <li><strong>Licencia:</strong> {{ $medico->numero_licencia }}</li>
        <li><strong>Biografía:</strong> {{ $medico->biografia ?? '—' }}</li>
    </ul>
</div>
@if($medico->horarios->isNotEmpty())
<div class="card">
    <h2>Horarios</h2>
    <table class="data-table">
        <thead><tr><th>Día</th><th>Inicio</th><th>Fin</th></tr></thead>
        <tbody>
            @foreach($medico->horarios as $h)
            <tr>
                <td>{{ \App\Http\Controllers\HorarioController::diaNombre($h->dia_semana) }}</td>
                <td>{{ substr($h->hora_inicio, 0, 5) }}</td>
                <td>{{ substr($h->hora_fin, 0, 5) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<a href="{{ route('medicos.index') }}" class="btn btn-secondary">Volver</a>
@endsection
