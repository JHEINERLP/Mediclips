@extends('layouts.app')
@section('title', 'Medicamentos')
@section('page-title', 'Inventario de medicamentos')
@section('content')
<div class="page-header">
    <h2>Medicamentos</h2>
    <a href="{{ route('medicamentos.create') }}" class="btn btn-primary">Nuevo medicamento</a>
</div>
<div class="card">
    @if($medicamentos->isEmpty())
        <p class="empty-state">No hay medicamentos en inventario.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Nombre</th><th>SKU</th><th>Stock</th><th>Descripción</th><th></th></tr></thead>
        <tbody>
            @foreach($medicamentos as $med)
            <tr>
                <td>{{ $med->nombre }}</td>
                <td>{{ $med->codigo_sku }}</td>
                <td>{{ $med->stock }} @if($med->stock < 10) ⚠️ @endif</td>
                <td>{{ Str::limit($med->descripcion, 40) }}</td>
                <td>
                    <a href="{{ route('medicamentos.edit', $med) }}" class="btn btn-sm btn-secondary">Editar</a>
                    <form method="POST" action="{{ route('medicamentos.destroy', $med) }}" class="inline-form" onsubmit="return confirm('¿Eliminar?')">
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
