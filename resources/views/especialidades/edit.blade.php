@extends('layouts.app')
@section('title', 'Editar especialidad')
@section('page-title', 'Editar especialidad')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('especialidades.update', $especialidad) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" value="{{ old('nombre', $especialidad->nombre) }}" required></div>
        <div class="form-group"><label>Descripción</label><textarea name="descripcion">{{ old('descripcion', $especialidad->descripcion) }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
