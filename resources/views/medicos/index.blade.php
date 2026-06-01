@extends('layouts.app')
@section('title', 'Médicos')
@section('page-title', 'Médicos')
@section('content')
<div class="page-header">
    <h2>Listado de médicos</h2>
    <a href="{{ route('medicos.create') }}" class="btn btn-primary">Nuevo médico</a>
</div>
<div class="card">
    @if($medicos->isEmpty())
        <p class="empty-state">No hay médicos registrados.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Nombre</th><th>Email</th><th>Especialidad</th><th>Licencia</th><th></th></tr></thead>
        <tbody>
            @foreach($medicos as $medico)
            <tr>
                <td>{{ $medico->user->name }}</td>
                <td>{{ $medico->user->email }}</td>
                <td>{{ $medico->especialidad->nombre }}</td>
                <td>{{ $medico->numero_licencia }}</td>
                <td>
                    <a href="{{ route('medicos.show', $medico) }}" class="btn btn-sm btn-secondary">Ver</a>
                    <a href="{{ route('medicos.edit', $medico) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="{{ route('medicos.reenviar', $medico) }}" class="inline-form">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">Reenviar correo</button>
                    </form>
                    <form method="POST" action="{{ route('medicos.destroy', $medico) }}" class="inline-form" onsubmit="return confirm('¿Eliminar médico?')">
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
