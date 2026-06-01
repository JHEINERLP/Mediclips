<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\ReporteClinico;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecetaController extends Controller
{
    public function index(): View
    {
        $recetas = Receta::with(['reporteClinico.cita.paciente.user'])
            ->whereHas('reporteClinico.cita', fn ($q) => $q->where('clinica_id', $this->clinicaId()))
            ->orderByDesc('created_at')
            ->get();

        return view('recetas.index', compact('recetas'));
    }

    public function create(Request $request): View
    {
        $reporteId = $request->query('reporte_id');
        $reporte = $reporteId ? ReporteClinico::with('cita.paciente.user')->findOrFail($reporteId) : null;

        if ($reporte && $reporte->cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        $reportes = ReporteClinico::with('cita.paciente.user')
            ->whereHas('cita', fn ($q) => $q->where('clinica_id', $this->clinicaId()))
            ->whereDoesntHave('receta')
            ->orderByDesc('created_at')
            ->get();

        return view('recetas.create', compact('reportes', 'reporte'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reporte_clinico_id' => ['required', 'exists:reportes_clinicos,id', 'unique:recetas,reporte_clinico_id'],
            'instrucciones_generales' => ['nullable', 'string'],
        ]);

        $reporte = ReporteClinico::with('cita')->findOrFail($data['reporte_clinico_id']);
        if ($reporte->cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        $receta = Receta::create($data);

        return redirect()->route('recetas.show', $receta)->with('success', 'Receta creada.');
    }

    public function show(Receta $receta): View
    {
        $this->authorizeReceta($receta);
        $receta->load(['reporteClinico.cita.paciente.user', 'reporteClinico.cita.medico.user', 'entregas.medicamento', 'entregas.farmaceutico']);

        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta): View
    {
        $this->authorizeReceta($receta);
        $receta->load('reporteClinico.cita.paciente.user');

        return view('recetas.edit', compact('receta'));
    }

    public function update(Request $request, Receta $receta)
    {
        $this->authorizeReceta($receta);

        $data = $request->validate([
            'instrucciones_generales' => ['nullable', 'string'],
        ]);

        $receta->update($data);

        return redirect()->route('recetas.show', $receta)->with('success', 'Receta actualizada.');
    }

    public function destroy(Receta $receta)
    {
        $this->authorizeReceta($receta);
        $receta->delete();

        return redirect()->route('recetas.index')->with('success', 'Receta eliminada.');
    }

    private function authorizeReceta(Receta $receta): void
    {
        if ($receta->reporteClinico->cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
