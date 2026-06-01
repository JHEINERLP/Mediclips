<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\EntregaMedicamento;
use App\Models\Medicamento;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $clinicaId = $this->clinicaId();
        $user = $this->user();

        $stats = [
            'medicos' => Medico::where('clinica_id', $clinicaId)->count(),
            'pacientes' => Paciente::where('clinica_id', $clinicaId)->count(),
            'citas_pendientes' => Cita::where('clinica_id', $clinicaId)->where('estado', 'pendiente')->count(),
            'medicamentos_bajo_stock' => Medicamento::where('clinica_id', $clinicaId)->where('stock', '<', 10)->count(),
        ];

        $citasQuery = Cita::with(['paciente.user', 'medico.user'])
            ->where('clinica_id', $clinicaId)
            ->orderByDesc('fecha_hora');

        if ($user->isMedico() && $user->medico) {
            $citasQuery->where('medico_id', $user->medico->id);
        } elseif ($user->isPaciente() && $user->paciente) {
            $citasQuery->where('paciente_id', $user->paciente->id);
        }

        $proximasCitas = $citasQuery->limit(5)->get();

        $entregasRecientes = collect();
        if ($user->isAdmin() || $user->isFarmaceutico()) {
            $entregasRecientes = EntregaMedicamento::with(['medicamento', 'farmaceutico', 'receta.reporteClinico.cita.paciente.user'])
                ->whereHas('medicamento', fn ($q) => $q->where('clinica_id', $clinicaId))
                ->orderByDesc('entregado_at')
                ->limit(5)
                ->get();
        }

        return view('dashboard.index', compact('stats', 'proximasCitas', 'entregasRecientes'));
    }
}
