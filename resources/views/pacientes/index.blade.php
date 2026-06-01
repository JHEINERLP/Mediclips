@extends('layouts.app')
@section('title', 'Pacientes')
@section('page-title', 'Pacientes')
@section('content')
<div class="page-header">
    <h2>Listado de pacientes</h2>
    <a href="{{ route('pacientes.create') }}" class="btn btn-primary">Nuevo paciente</a>
</div>
<div class="card">
    @if($pacientes->isEmpty())
        <p class="empty-state">No hay pacientes registrados.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Nombre</th><th>Email</th><th>Género</th><th>Fecha nac.</th><th></th></tr></thead>
        <tbody>
            @foreach($pacientes as $paciente)
            <tr>
                <td>{{ $paciente->user->name }}</td>
                <td>{{ $paciente->user->email }}</td>
                <td>{{ ucfirst($paciente->genero) }}</td>
                <td>{{ $paciente->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</td>
                <td>
                    <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-sm btn-secondary">Ver</a>
                    <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="{{ route('pacientes.reenviar', $paciente) }}" class="inline-form">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">Reenviar correo</button>
                    </form>
                    <form method="POST" action="{{ route('pacientes.destroy', $paciente) }}" class="inline-form" onsubmit="return confirm('¿Eliminar paciente?')">
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
