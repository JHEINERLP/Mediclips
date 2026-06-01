<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\ReporteClinico;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReporteClinicoController extends Controller
{
    public function index(): View
    {
        $reportes = ReporteClinico::with(['cita.paciente.user', 'cita.medico.user'])
            ->whereHas('cita', fn ($q) => $q->where('clinica_id', $this->clinicaId()))
            ->orderByDesc('created_at')
            ->get();

        return view('reportes.index', compact('reportes'));
    }

    public function create(Request $request): View
    {
        $citaId = $request->query('cita_id');
        $cita = $citaId
            ? Cita::with(['paciente.user', 'medico.user'])->findOrFail($citaId)
            : null;

        if ($cita && $cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        $citas = Cita::with(['paciente.user', 'medico.user'])
            ->where('clinica_id', $this->clinicaId())
            ->where('estado', 'completada')
            ->whereDoesntHave('reporteClinico')
            ->orderByDesc('fecha_hora')
            ->get();

        return view('reportes.create', compact('citas', 'cita'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cita_id' => ['required', 'exists:citas,id', 'unique:reportes_clinicos,cita_id'],
            'diagnostico' => ['required', 'string'],
            'plan_tratamiento' => ['required', 'string'],
        ]);

        $cita = Cita::findOrFail($data['cita_id']);
        if ($cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        $reporte = ReporteClinico::create($data);

        return redirect()->route('reportes.show', $reporte)->with('success', 'Reporte clínico creado.');
    }

    public function show(ReporteClinico $reporte): View
    {
        $this->authorizeReporte($reporte);
        $reporte->load(['cita.paciente.user', 'cita.medico.user', 'receta.entregas.medicamento']);

        return view('reportes.show', compact('reporte'));
    }

    public function edit(ReporteClinico $reporte): View
    {
        $this->authorizeReporte($reporte);
        $reporte->load('cita.paciente.user');

        return view('reportes.edit', compact('reporte'));
    }

    public function update(Request $request, ReporteClinico $reporte)
    {
        $this->authorizeReporte($reporte);

        $data = $request->validate([
            'diagnostico' => ['required', 'string'],
            'plan_tratamiento' => ['required', 'string'],
        ]);

        $reporte->update($data);

        return redirect()->route('reportes.show', $reporte)->with('success', 'Reporte actualizado.');
    }

    public function destroy(ReporteClinico $reporte)
    {
        $this->authorizeReporte($reporte);
        $reporte->delete();

        return redirect()->route('reportes.index')->with('success', 'Reporte eliminado.');
    }

    private function authorizeReporte(ReporteClinico $reporte): void
    {
        if ($reporte->cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
