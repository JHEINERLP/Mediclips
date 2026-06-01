<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HorarioController extends Controller
{
    private const DIAS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    public function index(): View
    {
        $horarios = Horario::with('medico.user')
            ->whereHas('medico', fn ($q) => $q->where('clinica_id', $this->clinicaId()))
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        return view('horarios.index', compact('horarios'));
    }

    public function create(): View
    {
        $medicos = Medico::with('user')->where('clinica_id', $this->clinicaId())->get();
        $dias = self::DIAS;

        return view('horarios.create', compact('medicos', 'dias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medico_id' => ['required', 'exists:medicos,id'],
            'dia_semana' => ['required', 'integer', 'between:1,7'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
        ]);

        $this->authorizeMedico($data['medico_id']);

        Horario::create($data);

        return redirect()->route('horarios.index')->with('success', 'Horario registrado.');
    }

    public function edit(Horario $horario): View
    {
        $this->authorizeHorario($horario);
        $medicos = Medico::with('user')->where('clinica_id', $this->clinicaId())->get();
        $dias = self::DIAS;

        return view('horarios.edit', compact('horario', 'medicos', 'dias'));
    }

    public function update(Request $request, Horario $horario)
    {
        $this->authorizeHorario($horario);

        $data = $request->validate([
            'medico_id' => ['required', 'exists:medicos,id'],
            'dia_semana' => ['required', 'integer', 'between:1,7'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
        ]);

        $this->authorizeMedico($data['medico_id']);
        $horario->update($data);

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado.');
    }

    public function destroy(Horario $horario)
    {
        $this->authorizeHorario($horario);
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado.');
    }

    public static function diaNombre(int $dia): string
    {
        return self::DIAS[$dia] ?? 'Desconocido';
    }

    private function authorizeHorario(Horario $horario): void
    {
        if ($horario->medico->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }

    private function authorizeMedico(int $medicoId): void
    {
        if (! Medico::where('id', $medicoId)->where('clinica_id', $this->clinicaId())->exists()) {
            abort(403);
        }
    }
}
