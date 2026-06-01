@extends('layouts.app')
@section('title', 'Nueva entrega')
@section('page-title', 'Registrar entrega')
@section('content')
<div class="card">
    <form method="POST" action="{{ route('entregas.store') }}">
        @csrf
        <div class="form-group">
            <label>Receta</label>
            <select name="receta_id" required>
                <option value="">Seleccionar...</option>
                @foreach($recetas as $r)
                    <option value="{{ $r->id }}" @selected(old('receta_id', $receta?->id) == $r->id)>
                        {{ $r->reporteClinico->cita->paciente->user->name }} — {{ $r->created_at->format('d/m/Y') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Medicamento</label>
            <select name="medicamento_id" required>
                <option value="">Seleccionar...</option>
                @foreach($medicamentos as $m)
                    <option value="{{ $m->id }}" @selected(old('medicamento_id') == $m->id)>{{ $m->nombre }} (Stock: {{ $m->stock }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Cantidad entregada</label><input type="number" name="cantidad_entregada" value="{{ old('cantidad_entregada', 1) }}" min="1" required></div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Registrar entrega</button>
            <a href="{{ route('entregas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
