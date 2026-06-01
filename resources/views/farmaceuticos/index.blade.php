@extends('layouts.app')
@section('title', 'Farmacéuticos')
@section('page-title', 'Farmacéuticos')
@section('content')
<div class="page-header">
    <h2>Listado de farmacéuticos</h2>
    <a href="{{ route('farmaceuticos.create') }}" class="btn btn-primary">Nuevo farmacéutico</a>
</div>
<div class="card">
    @if($farmaceuticos->isEmpty())
        <p class="empty-state">No hay farmacéuticos registrados.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Nombre</th><th>Email</th><th></th></tr></thead>
        <tbody>
            @foreach($farmaceuticos as $farmaceutico)
            <tr>
                <td>{{ $farmaceutico->name }}</td>
                <td>{{ $farmaceutico->email }}</td>
                <td>
                    <a href="{{ route('farmaceuticos.edit', $farmaceutico) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="{{ route('farmaceuticos.reenviar', $farmaceutico) }}" class="inline-form">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">Reenviar correo</button>
                    </form>
                    <form method="POST" action="{{ route('farmaceuticos.destroy', $farmaceutico) }}" class="inline-form" onsubmit="return confirm('¿Eliminar farmacéutico?')">
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
