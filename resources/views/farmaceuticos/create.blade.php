@extends('layouts.app')
@section('title', 'Nuevo farmacéutico')
@section('page-title', 'Registrar farmacéutico')
@section('content')
<div class="card">
    <p style="color:#64748b;margin-bottom:16px;font-size:0.9em;">
        Al guardar se enviará un correo de aviso al farmacéutico con el enlace para iniciar sesión.
    </p>
    <form method="POST" action="{{ route('farmaceuticos.store') }}">
        @csrf
        <div class="form-group"><label>Nombre</label><input type="text" name="name" value="{{ old('name') }}" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="form-group"><label>Contraseña</label><input type="password" name="password" required></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('farmaceuticos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
