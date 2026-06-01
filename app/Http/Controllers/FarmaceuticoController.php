<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserInvitationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FarmaceuticoController extends Controller
{
    public function index(): View
    {
        $farmaceuticos = User::where('clinica_id', $this->clinicaId())
            ->where('rol', 'farmaceutico')
            ->orderBy('name')
            ->get();

        return view('farmaceuticos.index', compact('farmaceuticos'));
    }

    public function create(): View
    {
        return view('farmaceuticos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $clinica = $this->user()->clinica;

        $user = User::create([
            'clinica_id' => $clinica->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'rol' => 'farmaceutico',
        ]);

        UserInvitationService::sendNotification($user, $clinica);

        return redirect()->route('farmaceuticos.index')
            ->with('success', 'Farmacéutico registrado. Se envió un correo de aviso al usuario.');
    }

    public function edit(User $farmaceutico): View
    {
        $this->authorizeFarmaceutico($farmaceutico);

        return view('farmaceuticos.edit', compact('farmaceutico'));
    }

    public function update(Request $request, User $farmaceutico)
    {
        $this->authorizeFarmaceutico($farmaceutico);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$farmaceutico->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $farmaceutico->update([
            'name' => $data['name'],
            'email' => $data['email'],
            ...($data['password'] ? ['password' => $data['password']] : []),
        ]);

        return redirect()->route('farmaceuticos.index')->with('success', 'Farmacéutico actualizado.');
    }

    public function destroy(User $farmaceutico)
    {
        $this->authorizeFarmaceutico($farmaceutico);
        $farmaceutico->delete();

        return redirect()->route('farmaceuticos.index')->with('success', 'Farmacéutico eliminado.');
    }

    public function reenviarInvitacion(User $farmaceutico)
    {
        $this->authorizeFarmaceutico($farmaceutico);
        UserInvitationService::resendNotification($farmaceutico);

        return back()->with('success', 'Correo de aviso reenviado al farmacéutico.');
    }

    private function authorizeFarmaceutico(User $farmaceutico): void
    {
        if ($farmaceutico->rol !== 'farmaceutico' || $farmaceutico->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
