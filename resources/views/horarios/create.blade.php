@extends('layouts.app')
@section('title', 'Nuevo horario')
@section('page-title', 'Registrar horario')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('horarios.store') }}">
        @csrf
        <div class="form-group">
            <label>Médico</label>
            <select name="medico_id" required>
                <option value="">Seleccionar...</option>
                @foreach($medicos as $m)
                    <option value="{{ $m->id }}" @selected(old('medico_id') == $m->id)>{{ $m->user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Día</label>
            <select name="dia_semana" required>
                @foreach($dias as $num => $nombre)
                    <option value="{{ $num }}" @selected(old('dia_semana') == $num)>{{ $nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Hora inicio</label><input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required></div>
        <div class="form-group"><label>Hora fin</label><input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
