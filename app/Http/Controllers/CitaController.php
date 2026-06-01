<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitaController extends Controller
{
    public function index(): View
    {
        $query = Cita::with(['paciente.user', 'medico.user'])
            ->where('clinica_id', $this->clinicaId())
            ->orderByDesc('fecha_hora');

        if ($this->user()->isMedico() && $this->user()->medico) {
            $query->where('medico_id', $this->user()->medico->id);
        } elseif ($this->user()->isPaciente() && $this->user()->paciente) {
            $query->where('paciente_id', $this->user()->paciente->id);
        }

        $citas = $query->get();

        return view('citas.index', compact('citas'));
    }

    public function create(): View
    {
        $medicos = Medico::with(['user', 'especialidad'])->where('clinica_id', $this->clinicaId())->get();
        $pacientes = Paciente::with('user')->where('clinica_id', $this->clinicaId())->get();

        if ($this->user()->isPaciente() && $this->user()->paciente) {
            $pacientes = $pacientes->where('id', $this->user()->paciente->id);
        }

        return view('citas.create', compact('medicos', 'pacientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => ['required', 'exists:pacientes,id'],
            'medico_id' => ['required', 'exists:medicos,id'],
            // Permitimos agendar para "ahora" también (after_or_equal) para evitar fallos
            // por segundos/zonas horarias del navegador.
            'fecha_hora' => ['required', 'date', 'after_or_equal:now'],
            'motivo' => ['required', 'string'],
        ]);

        $this->validateClinicaOwnership($data['paciente_id'], $data['medico_id']);

        if ($this->user()->isPaciente() && $this->user()->paciente?->id != $data['paciente_id']) {
            abort(403);
        }

        Cita::create([
            'clinica_id' => $this->clinicaId(),
            'paciente_id' => $data['paciente_id'],
            'medico_id' => $data['medico_id'],
            'fecha_hora' => $data['fecha_hora'],
            'motivo' => $data['motivo'],
            'estado' => 'pendiente',
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada correctamente.');
    }

    public function show(Cita $cita): View
    {
        $this->authorizeCita($cita);
        $cita->load(['paciente.user', 'medico.user', 'reporteClinico.receta.entregas.medicamento']);

        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita): View
    {
        $this->authorizeCita($cita);
        $medicos = Medico::with(['user', 'especialidad'])->where('clinica_id', $this->clinicaId())->get();
        $pacientes = Paciente::with('user')->where('clinica_id', $this->clinicaId())->get();

        return view('citas.edit', compact('cita', 'medicos', 'pacientes'));
    }

    public function update(Request $request, Cita $cita)
    {
        $this->authorizeCita($cita);

        $data = $request->validate([
            'paciente_id' => ['required', 'exists:pacientes,id'],
            'medico_id' => ['required', 'exists:medicos,id'],
            'fecha_hora' => ['required', 'date'],
            'motivo' => ['required', 'string'],
            'estado' => ['required', 'in:pendiente,aceptada,rechazada,cancelada,completada'],
        ]);

        $this->validateClinicaOwnership($data['paciente_id'], $data['medico_id']);

        $cita->update($data);

        return redirect()->route('citas.index')->with('success', 'Cita actualizada.');
    }

    public function destroy(Cita $cita)
    {
        $this->authorizeCita($cita);
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada.');
    }

    public function updateEstado(Request $request, Cita $cita)
    {
        $this->authorizeCita($cita);

        $data = $request->validate([
            'estado' => ['required', 'in:pendiente,aceptada,rechazada,cancelada,completada'],
        ]);

        if ($this->user()->isPaciente() && ! in_array($data['estado'], ['cancelada'], true)) {
            abort(403);
        }

        $cita->update(['estado' => $data['estado']]);

        return back()->with('success', 'Estado de la cita actualizado.');
    }

    private function authorizeCita(Cita $cita): void
    {
        if ($cita->clinica_id !== $this->clinicaId()) {
            abort(403);
        }

        if ($this->user()->isMedico() && $this->user()->medico?->id !== $cita->medico_id) {
            abort(403);
        }

        if ($this->user()->isPaciente() && $this->user()->paciente?->id !== $cita->paciente_id) {
            abort(403);
        }
    }

    private function validateClinicaOwnership(int $pacienteId, int $medicoId): void
    {
        $pacienteOk = Paciente::where('id', $pacienteId)->where('clinica_id', $this->clinicaId())->exists();
        $medicoOk = Medico::where('id', $medicoId)->where('clinica_id', $this->clinicaId())->exists();

        if (! $pacienteOk || ! $medicoOk) {
            abort(403);
        }
    }
}
