<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EspecialidadController extends Controller
{
    public function index(): View
    {
        $especialidades = Especialidad::withCount('medicos')->orderBy('nombre')->get();

        return view('especialidades.index', compact('especialidades'));
    }

    public function create(): View
    {
        return view('especialidades.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:especialidades,nombre'],
            'descripcion' => ['nullable', 'string'],
        ]);

        Especialidad::create($data);

        return redirect()->route('especialidades.index')->with('success', 'Especialidad creada.');
    }

    public function edit(Especialidad $especialidad): View
    {
        return view('especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, Especialidad $especialidad)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:especialidades,nombre,'.$especialidad->id],
            'descripcion' => ['nullable', 'string'],
        ]);

        $especialidad->update($data);

        return redirect()->route('especialidades.index')->with('success', 'Especialidad actualizada.');
    }

    public function destroy(Especialidad $especialidad)
    {
        if ($especialidad->medicos()->exists()) {
            return back()->withErrors(['message' => 'No se puede eliminar: hay médicos asociados.']);
        }

        $especialidad->delete();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada.');
    }
}
