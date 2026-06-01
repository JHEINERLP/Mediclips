<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicamentoController extends Controller
{
    public function index(): View
    {
        $medicamentos = Medicamento::where('clinica_id', $this->clinicaId())
            ->orderBy('nombre')
            ->get();

        return view('medicamentos.index', compact('medicamentos'));
    }

    public function create(): View
    {
        return view('medicamentos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'codigo_sku' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'descripcion' => ['nullable', 'string'],
        ]);

        Medicamento::create([
            ...$data,
            'clinica_id' => $this->clinicaId(),
        ]);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento registrado.');
    }

    public function edit(Medicamento $medicamento): View
    {
        $this->authorizeMedicamento($medicamento);

        return view('medicamentos.edit', compact('medicamento'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $this->authorizeMedicamento($medicamento);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'codigo_sku' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $medicamento->update($data);

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento actualizado.');
    }

    public function destroy(Medicamento $medicamento)
    {
        $this->authorizeMedicamento($medicamento);
        $medicamento->delete();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento eliminado.');
    }

    private function authorizeMedicamento(Medicamento $medicamento): void
    {
        if ($medicamento->clinica_id !== $this->clinicaId()) {
            abort(403);
        }
    }
}
