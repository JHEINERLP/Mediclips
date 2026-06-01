@extends('layouts.app')
@section('title', 'Nuevo medicamento')
@section('page-title', 'Registrar medicamento')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('medicamentos.store') }}">
        @csrf
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" value="{{ old('nombre') }}" required></div>
        <div class="form-group"><label>Código SKU</label><input type="text" name="codigo_sku" value="{{ old('codigo_sku') }}" required></div>
        <div class="form-group"><label>Stock</label><input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required></div>
        <div class="form-group"><label>Descripción</label><textarea name="descripcion">{{ old('descripcion') }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('medicamentos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
