<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clinica;
use App\Models\TransaccionPago;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\UserInvitationService;
use Illuminate\Support\Str;

class RegisterCompanyController extends Controller
{
    private const PLAN_PRICES = [
        'basico' => 99000,
        'pro' => 199000,
        'premium' => 349000,
    ];

    public function create()
    {
        return view('auth.register_company');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_empresa' => ['required', 'string', 'max:255'],
            'subdominio' => ['required', 'string', 'max:63', 'alpha_dash', 'unique:clinicas,subdominio'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'plan' => ['required', 'in:basico,pro,premium'],
            'pago' => ['required', 'in:tarjeta,nequi,daviplata,transferencia'],
        ]);

        $user = null;

        $clinica = DB::transaction(function () use ($data, &$user) {
            $clinica = Clinica::create([
                'nombre' => $data['nombre_empresa'],
                'subdominio' => Str::lower($data['subdominio']),
                'plan_suscripcion' => $data['plan'],
                'estado' => 'activo',
                'vigente_hasta' => now()->addMonth(),
            ]);

            $user = User::create([
                'clinica_id' => $clinica->id,
                'name' => $data['nombre_empresa'].' Admin',
                'email' => $data['email'],
                'password' => $data['password'],
                'rol' => 'admin',
            ]);

            TransaccionPago::create([
                'clinica_id' => $clinica->id,
                'monto' => self::PLAN_PRICES[$data['plan']],
                'estado_pago' => 'pendiente',
                'pagado_at' => null,
            ]);

            return $clinica;
        });

        UserInvitationService::sendNotification($user, $clinica, isSelfRegistration: true);
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', '¡Empresa registrada correctamente! Revisa tu correo de confirmación.');
    }
}
