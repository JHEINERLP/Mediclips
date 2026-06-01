@extends('layouts.app')
@section('title', 'Especialidades')
@section('page-title', 'Especialidades médicas')
@section('content')
<div class="page-header">
    <h2>Especialidades</h2>
    <a href="{{ route('especialidades.create') }}" class="btn btn-primary">Nueva especialidad</a>
</div>
<div class="card">
    @if($especialidades->isEmpty())
        <p class="empty-state">No hay especialidades.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Nombre</th><th>Descripción</th><th>Médicos</th><th></th></tr></thead>
        <tbody>
            @foreach($especialidades as $esp)
            <tr>
                <td>{{ $esp->nombre }}</td>
                <td>{{ Str::limit($esp->descripcion, 50) }}</td>
                <td>{{ $esp->medicos_count }}</td>
                <td>
                    <a href="{{ route('especialidades.edit', $esp) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="{{ route('especialidades.destroy', $esp) }}" class="inline-form" onsubmit="return confirm('¿Eliminar?')">
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
