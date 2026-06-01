@extends('layouts.app')
@section('title', 'Editar médico')
@section('page-title', 'Editar médico')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('medicos.update', $medico) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Nombre</label><input type="text" name="name" value="{{ old('name', $medico->user->name) }}" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $medico->user->email) }}" required></div>
        <div class="form-group"><label>Nueva contraseña (opcional)</label><input type="password" name="password"></div>
        <div class="form-group">
            <label>Especialidad</label>
            <select name="especialidad_id" required>
                @foreach($especialidades as $esp)
                    <option value="{{ $esp->id }}" @selected(old('especialidad_id', $medico->especialidad_id) == $esp->id)>{{ $esp->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Número de licencia</label><input type="text" name="numero_licencia" value="{{ old('numero_licencia', $medico->numero_licencia) }}" required></div>
        <div class="form-group"><label>Biografía</label><textarea name="biografia">{{ old('biografia', $medico->biografia) }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('medicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
