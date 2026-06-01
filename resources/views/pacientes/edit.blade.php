@extends('layouts.app')
@section('title', 'Editar paciente')
@section('page-title', 'Editar paciente')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('pacientes.update', $paciente) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Nombre</label><input type="text" name="name" value="{{ old('name', $paciente->user->name) }}" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $paciente->user->email) }}" required></div>
        <div class="form-group"><label>Nueva contraseña (opcional)</label><input type="password" name="password"></div>
        <div class="form-group"><label>Fecha de nacimiento</label><input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento->format('Y-m-d')) }}" required></div>
        <div class="form-group">
            <label>Género</label>
            <select name="genero" required>
                @foreach(['masculino','femenino','otro'] as $g)
                    <option value="{{ $g }}" @selected(old('genero', $paciente->genero) === $g)>{{ ucfirst($g) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Grupo sanguíneo</label><input type="text" name="grupo_sanguineo" value="{{ old('grupo_sanguineo', $paciente->grupo_sanguineo) }}"></div>
        <div class="form-group"><label>Contacto de emergencia</label><input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia', $paciente->contacto_emergencia) }}"></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
