@extends('layouts.app')
@section('title', 'Editar farmacéutico')
@section('page-title', 'Editar farmacéutico')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('farmaceuticos.update', $farmaceutico) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Nombre</label><input type="text" name="name" value="{{ old('name', $farmaceutico->name) }}" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $farmaceutico->email) }}" required></div>
        <div class="form-group"><label>Nueva contraseña (opcional)</label><input type="password" name="password"></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="{{ route('farmaceuticos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
