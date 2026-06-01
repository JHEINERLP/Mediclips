@extends('layouts.app')
@section('title', 'Reportes clínicos')
@section('page-title', 'Reportes clínicos')
@section('content')
<div class="page-header">
    <h2>Reportes</h2>
    <a href="{{ route('reportes.create') }}" class="btn btn-primary">Nuevo reporte</a>
</div>
<div class="card">
    @if($reportes->isEmpty())
        <p class="empty-state">No hay reportes clínicos.</p>
    @else
    <table class="data-table">
        <thead><tr><th>Fecha</th><th>Paciente</th><th>Médico</th><th>Diagnóstico</th><th></th></tr></thead>
        <tbody>
            @foreach($reportes as $r)
            <tr>
                <td>{{ $r->created_at->format('d/m/Y') }}</td>
                <td>{{ $r->cita->paciente->user->name }}</td>
                <td>{{ $r->cita->medico->user->name }}</td>
                <td>{{ Str::limit($r->diagnostico, 40) }}</td>
                <td><a href="{{ route('reportes.show', $r) }}" class="btn btn-sm btn-secondary">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
