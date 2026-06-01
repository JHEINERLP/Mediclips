@extends('layouts.app')
@section('title', 'Editar medicamento')
@section('page-title', 'Editar medicamento')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('medicamentos.update', $medicamento) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" value="{{ old('nombre', $medicamento->nombre) }}" required></div>
        <div class="form-group"><label>Código SKU</label><input type="text" name="codigo_sku" value="{{ old('codigo_sku', $medicamento->codigo_sku) }}" required></div>
        <div class="form-group"><label>Stock</label><input type="number" name="stock" value="{{ old('stock', $medicamento->stock) }}" min="0" required></div>
        <div class="form-group"><label>Descripción</label><textarea name="descripcion">{{ old('descripcion', $medicamento->descripcion) }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('medicamentos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
