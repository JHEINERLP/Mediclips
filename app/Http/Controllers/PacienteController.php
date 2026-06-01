<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use App\Services\UserInvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PacienteController extends Controller
{
    public function index(): View
    {
        $pacientes = Paciente::with('user')
            ->where('clinica_id', $this->clinicaId())
            ->orderBy('id')
            ->get();

        return view('pacientes.index', compact('pacientes'));
    }

    public function create(): View
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'fecha_nacimiento' => ['required', 'date'],
            'genero' => ['required', 'in:masculino,femenino,otro'],
            'grupo_sanguineo' => ['nullable', 'string', 'max:10'],
            'contacto_emergencia' => ['nullable', 'string', 'max:255'],
        ]);

        $clinica = $this->user()->clinica;

        DB::transaction(function () use ($data, $clinica) {
            $user = User::create([
                'clinica_id' => $this->clinicaId(),
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'rol' => 'paciente',
            ]);

            Paciente::create([
                'usuario_id' => $user->id,
                'clinica_id' => $this->clinicaId(),
                'fecha_nacimiento' => $data['fecha_nacimiento'],
                'genero' => $data['genero'],
                'grupo_sanguineo' => $data['grupo_sanguineo'] ?? null,
                'contacto_emergencia' => $data['contacto_emergencia'] ?? null,
            ]);

            UserInvitationService::sendNotification($user, $clinica);
        });

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente registrado. Se envió un correo de aviso al usuario.');
    }

    public function show(Paciente $paciente): View
    {
        $this->authorizePaciente($paciente);
        $paciente->load(['user', 'citas.medico.user']);

        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente): View
    {
        $this->authorizePaciente($paciente);
        $paciente->load('user');

        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $this->authorizePaciente($paciente);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$paciente->usuario_id],
            'fecha_nacimiento' => ['required', 'date'],
            'genero' => ['required', 'in:masculino,femenino,otro'],
            'grupo_sanguineo' => ['nullable', 'string', 'max:10'],
            'contacto_emergencia' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $paciente->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            ...($data['password'] ? ['password' => $data['password']] : []),
        ]);

        $paciente->update([
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'genero' => $data['genero'],
            'grupo_sanguineo' => $data['grupo_sanguineo'] ?? null,
            'contacto_emergencia' => $data['contacto_emergencia'] ?? null,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado.');
    }

    public function destroy(Paciente $paciente)
    {
        $this->authorizePaciente($paciente);
        $paciente->user->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado.');
    }

    public function reenviarInvitacion(Paciente $paciente)
    {
        $this->authorizePaciente($paciente);
        UserInvitationService::resendNotification($paciente->user);

        return back()->with('success', 'Correo de aviso reenviado al paciente.');
    }

    private function authorizePaciente(Paciente $paciente): void
    {
        if ($paciente->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
