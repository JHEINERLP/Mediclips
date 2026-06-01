<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\User;
use App\Services\UserInvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MedicoController extends Controller
{
    public function index(): View
    {
        $medicos = Medico::with(['user', 'especialidad'])
            ->where('clinica_id', $this->clinicaId())
            ->orderBy('id')
            ->get();

        return view('medicos.index', compact('medicos'));
    }

    public function create(): View
    {
        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('medicos.create', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'especialidad_id' => ['required', 'exists:especialidades,id'],
            'numero_licencia' => ['required', 'string', 'max:255'],
            'biografia' => ['nullable', 'string'],
        ]);

        $clinica = $this->user()->clinica;

        DB::transaction(function () use ($data, $clinica) {
            $user = User::create([
                'clinica_id' => $this->clinicaId(),
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'rol' => 'medico',
            ]);

            Medico::create([
                'user_id' => $user->id,
                'clinica_id' => $this->clinicaId(),
                'especialidad_id' => $data['especialidad_id'],
                'numero_licencia' => $data['numero_licencia'],
                'biografia' => $data['biografia'] ?? null,
            ]);

            UserInvitationService::sendNotification($user, $clinica);
        });

        return redirect()->route('medicos.index')
            ->with('success', 'Médico registrado. Se envió un correo de aviso al usuario.');
    }

    public function show(Medico $medico): View
    {
        $this->authorizeMedico($medico);
        $medico->load(['user', 'especialidad', 'horarios', 'citas.paciente.user']);

        return view('medicos.show', compact('medico'));
    }

    public function edit(Medico $medico): View
    {
        $this->authorizeMedico($medico);
        $especialidades = Especialidad::orderBy('nombre')->get();
        $medico->load('user');

        return view('medicos.edit', compact('medico', 'especialidades'));
    }

    public function update(Request $request, Medico $medico)
    {
        $this->authorizeMedico($medico);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$medico->user_id],
            'especialidad_id' => ['required', 'exists:especialidades,id'],
            'numero_licencia' => ['required', 'string', 'max:255'],
            'biografia' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $medico->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            ...($data['password'] ? ['password' => $data['password']] : []),
        ]);

        $medico->update([
            'especialidad_id' => $data['especialidad_id'],
            'numero_licencia' => $data['numero_licencia'],
            'biografia' => $data['biografia'] ?? null,
        ]);

        return redirect()->route('medicos.index')->with('success', 'Médico actualizado.');
    }

    public function destroy(Medico $medico)
    {
        $this->authorizeMedico($medico);
        $medico->user->delete();

        return redirect()->route('medicos.index')->with('success', 'Médico eliminado.');
    }

    public function reenviarInvitacion(Medico $medico)
    {
        $this->authorizeMedico($medico);
        UserInvitationService::resendNotification($medico->user);

        return back()->with('success', 'Correo de aviso reenviado al médico.');
    }

    private function authorizeMedico(Medico $medico): void
    {
        if ($medico->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
