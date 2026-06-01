<?php

namespace App\Http\Controllers;

use App\Models\EntregaMedicamento;
use App\Models\Medicamento;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntregaMedicamentoController extends Controller
{
    public function index(): View
    {
        $entregas = EntregaMedicamento::with(['receta.reporteClinico.cita.paciente.user', 'medicamento', 'farmaceutico'])
            ->whereHas('medicamento', fn ($q) => $q->where('clinica_id', $this->clinicaId()))
            ->orderByDesc('entregado_at')
            ->get();

        return view('entregas.index', compact('entregas'));
    }

    public function create(Request $request): View
    {
        $recetaId = $request->query('receta_id');
        $receta = $recetaId ? Receta::with('reporteClinico.cita.paciente.user')->findOrFail($recetaId) : null;

        if ($receta && $receta->reporteClinico->cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        $recetas = Receta::with('reporteClinico.cita.paciente.user')
            ->whereHas('reporteClinico.cita', fn ($q) => $q->where('clinica_id', $this->clinicaId()))
            ->orderByDesc('created_at')
            ->get();

        $medicamentos = Medicamento::where('clinica_id', $this->clinicaId())->where('stock', '>', 0)->orderBy('nombre')->get();

        return view('entregas.create', compact('recetas', 'receta', 'medicamentos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receta_id' => ['required', 'exists:recetas,id'],
            'medicamento_id' => ['required', 'exists:medicamentos,id'],
            'cantidad_entregada' => ['required', 'integer', 'min:1'],
        ]);

        $receta = Receta::with('reporteClinico.cita')->findOrFail($data['receta_id']);
        $medicamento = Medicamento::findOrFail($data['medicamento_id']);

        if ($receta->reporteClinico->cita->clinica_id !== $this->clinicaId()
            || $medicamento->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        if ($medicamento->stock < $data['cantidad_entregada']) {
            return back()->withErrors(['cantidad_entregada' => 'Stock insuficiente. Disponible: '.$medicamento->stock]);
        }

        DB::transaction(function () use ($data, $medicamento) {
            EntregaMedicamento::create([
                'receta_id' => $data['receta_id'],
                'medicamento_id' => $data['medicamento_id'],
                'farmaceutico_id' => $this->user()->id,
                'cantidad_entregada' => $data['cantidad_entregada'],
                'entregado_at' => now(),
            ]);

            $medicamento->decrement('stock', $data['cantidad_entregada']);
        });

        return redirect()->route('entregas.index')->with('success', 'Entrega registrada.');
    }

    public function show(EntregaMedicamento $entrega): View
    {
        $this->authorizeEntrega($entrega);
        $entrega->load(['receta.reporteClinico.cita.paciente.user', 'medicamento', 'farmaceutico']);

        return view('entregas.show', compact('entrega'));
    }

    private function authorizeEntrega(EntregaMedicamento $entrega): void
    {
        if ($entrega->medicamento->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
