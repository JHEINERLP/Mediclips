<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\Paciente;
use App\Models\User;
use App\Services\UserInvitationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterPacienteController extends Controller
{
    public function create()
    {
        $clinicas = Clinica::where('estado', 'activo')->orderBy('nombre')->get();

        return view('auth.register_paciente', compact('clinicas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'clinica_id' => ['required', 'exists:clinicas,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $clinica = Clinica::where('id', $data['clinica_id'])->where('estado', 'activo')->firstOrFail();

        $user = DB::transaction(function () use ($data, $clinica) {
            $user = User::create([
                'clinica_id' => $clinica->id,
                'name' => Str::before($data['email'], '@'),
                'email' => $data['email'],
                'password' => $data['password'],
                'rol' => 'paciente',
            ]);

            Paciente::create([
                'usuario_id' => $user->id,
                'clinica_id' => $clinica->id,
            ]);

            return $user;
        });

        UserInvitationService::sendNotification($user, $clinica, isSelfRegistration: true);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '¡Registro completado! Revisa tu correo de confirmación.');
    }
}
