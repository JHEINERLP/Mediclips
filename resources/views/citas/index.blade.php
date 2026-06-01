@extends('layouts.app')
@section('title', 'Citas')
@section('page-title', 'Citas')
@section('content')
<div class="page-header">
    <h2>Listado de citas</h2>
    <a href="{{ route('citas.create') }}" class="btn btn-primary">Agendar cita</a>
</div>
<div class="card">
    @if($citas->isEmpty())
        <p class="empty-state">No hay citas registradas.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Fecha</th><th>Paciente</th><th>Médico</th><th>Motivo</th><th>Estado</th><th></th></tr></thead>
        <tbody>
            @foreach($citas as $cita)
            <tr>
                <td>{{ $cita->fecha_hora->format('d/m/Y H:i') }}</td>
                <td>{{ $cita->paciente->user->name }}</td>
                <td>{{ $cita->medico->user->name }}</td>
                <td>{{ Str::limit($cita->motivo, 40) }}</td>
                <td><span class="badge badge-{{ $cita->estado }}">{{ ucfirst($cita->estado) }}</span></td>
                <td><a href="{{ route('citas.show', $cita) }}" class="btn btn-sm btn-secondary">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
