@extends('layouts.app')
@section('title', 'Mi clínica')
@section('page-title', 'Configuración de la clínica')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('clinica.update') }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" value="{{ old('nombre', $clinica->nombre) }}" required></div>
        <div class="form-group"><label>Subdominio</label><input type="text" name="subdominio" value="{{ old('subdominio', $clinica->subdominio) }}" required></div>
        <div class="form-group">
            <label>Plan</label>
            <select name="plan_suscripcion" required>
                @foreach(['basico','pro','premium'] as $p)
                    <option value="{{ $p }}" @selected(old('plan_suscripcion', $clinica->plan_suscripcion) === $p)>{{ ucfirst($p) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <select name="estado" required>
                <option value="activo" @selected(old('estado', $clinica->estado) === 'activo')>Activo</option>
                <option value="inactivo" @selected(old('estado', $clinica->estado) === 'inactivo')>Inactivo</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
