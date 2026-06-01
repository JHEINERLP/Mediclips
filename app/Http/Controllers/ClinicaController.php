<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClinicaController extends Controller
{
    public function edit(): View
    {
        $clinica = Clinica::findOrFail($this->clinicaId());

        return view('clinica.edit', compact('clinica'));
    }

    public function update(Request $request)
    {
        $clinica = Clinica::findOrFail($this->clinicaId());

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'subdominio' => ['required', 'string', 'max:63', 'alpha_dash', 'unique:clinicas,subdominio,'.$clinica->id],
            'plan_suscripcion' => ['required', 'in:basico,pro,premium'],
            'estado' => ['required', 'in:activo,inactivo'],
        ]);

        $clinica->update($data);

        return redirect()->route('clinica.edit')->with('success', 'Datos de la clínica actualizados.');
    }
}
