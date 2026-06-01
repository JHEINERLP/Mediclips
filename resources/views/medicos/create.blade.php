@extends('layouts.app')
@section('title', 'Nuevo médico')
@section('page-title', 'Registrar médico')
@section('content')
<div class="card">
    <p style="color:#64748b;margin-bottom:16px;font-size:0.9em;">
        Al guardar se enviará un correo de aviso al médico con el enlace para iniciar sesión.
    </p>
    <form method="POST" action="{{ route('medicos.store') }}">
        @csrf
        <div class="form-group"><label>Nombre</label><input type="text" name="name" value="{{ old('name') }}" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="form-group"><label>Contraseña</label><input type="password" name="password" required></div>
        <div class="form-group">
            <label>Especialidad</label>
            <select name="especialidad_id" required>
                <option value="">Seleccionar...</option>
                @foreach($especialidades as $esp)
                    <option value="{{ $esp->id }}" @selected(old('especialidad_id') == $esp->id)>{{ $esp->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Número de licencia</label><input type="text" name="numero_licencia" value="{{ old('numero_licencia') }}" required></div>
        <div class="form-group"><label>Biografía</label><textarea name="biografia">{{ old('biografia') }}</textarea></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('medicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
