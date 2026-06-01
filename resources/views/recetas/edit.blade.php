@extends('layouts.app')
@section('title', 'Editar receta')
@section('page-title', 'Editar receta')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('recetas.update', $receta) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Instrucciones generales</label><textarea name="instrucciones_generales">{{ old('instrucciones_generales', $receta->instrucciones_generales) }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('recetas.show', $receta) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
