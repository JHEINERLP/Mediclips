@extends('layouts.app')
@section('title', 'Nueva especialidad')
@section('page-title', 'Nueva especialidad')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('especialidades.store') }}">
        @csrf
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" value="{{ old('nombre') }}" required></div>
        <div class="form-group"><label>Descripción</label><textarea name="descripcion">{{ old('descripcion') }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('especialidades.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
