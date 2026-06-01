@extends('layouts.app')
@section('title', 'Nuevo paciente')
@section('page-title', 'Registrar paciente')
@section('content')
<div class="card">
    <p style="color:#64748b;margin-bottom:16px;font-size:0.9em;">
        Al guardar se enviará un correo de aviso al paciente. También puede registrarse en
        <a href="{{ route('registro.paciente') }}" target="_blank">/registro-paciente</a> con su correo y contraseña.
    </p>
    <form method="POST" action="{{ route('pacientes.store') }}">
        @csrf
        <div class="form-group"><label>Nombre</label><input type="text" name="name" value="{{ old('name') }}" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="form-group"><label>Contraseña</label><input type="password" name="password" required></div>
        <div class="form-group"><label>Fecha de nacimiento</label><input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required></div>
        <div class="form-group">
            <label>Género</label>
            <select name="genero" required>
                <option value="masculino" @selected(old('genero') === 'masculino')>Masculino</option>
                <option value="femenino" @selected(old('genero') === 'femenino')>Femenino</option>
                <option value="otro" @selected(old('genero') === 'otro')>Otro</option>
            </select>
        </div>
        <div class="form-group"><label>Grupo sanguíneo</label><input type="text" name="grupo_sanguineo" value="{{ old('grupo_sanguineo') }}"></div>
        <div class="form-group"><label>Contacto de emergencia</label><input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia') }}"></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
