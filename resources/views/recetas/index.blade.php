@extends('layouts.app')
@section('title', 'Recetas')
@section('page-title', 'Recetas médicas')
@section('content')
<div class="page-header">
    <h2>Recetas</h2>
    <a href="{{ route('recetas.create') }}" class="btn btn-primary">Nueva receta</a>
</div>
<div class="card">
    @if($recetas->isEmpty())
        <p class="empty-state">No hay recetas.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Fecha</th><th>Paciente</th><th>Instrucciones</th><th></th></tr></thead>
        <tbody>
            @foreach($recetas as $rec)
            <tr>
                <td>{{ $rec->created_at->format('d/m/Y') }}</td>
                <td>{{ $rec->reporteClinico->cita->paciente->user->name }}</td>
                <td>{{ Str::limit($rec->instrucciones_generales, 40) }}</td>
                <td><a href="{{ route('recetas.show', $rec) }}" class="btn btn-sm btn-secondary">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
