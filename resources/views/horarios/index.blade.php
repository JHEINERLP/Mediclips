@extends('layouts.app')
@section('title', 'Horarios')
@section('page-title', 'Horarios médicos')
@section('content')
<div class="page-header">
    <h2>Horarios</h2>
    <a href="{{ route('horarios.create') }}" class="btn btn-primary">Nuevo horario</a>
</div>
<div class="card">
    @if($horarios->isEmpty())
        <p class="empty-state">No hay horarios registrados.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Médico</th><th>Día</th><th>Inicio</th><th>Fin</th><th></th></tr></thead>
        <tbody>
            @foreach($horarios as $h)
            <tr>
                <td>{{ $h->medico->user->name }}</td>
                <td>{{ \App\Http\Controllers\HorarioController::diaNombre($h->dia_semana) }}</td>
                <td>{{ substr($h->hora_inicio, 0, 5) }}</td>
                <td>{{ substr($h->hora_fin, 0, 5) }}</td>
                <td>
                    <a href="{{ route('horarios.edit', $h) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="{{ route('horarios.destroy', $h) }}" class="inline-form" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
