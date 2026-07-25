<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\Cargo;
use App\Enums\TipoDocumento;
use App\Models\Empresa;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('modules.trabajadores.index', compact('trabajadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cargos = Cargo::all();
        $empresas = Empresa::all();
        return view('modules.trabajadores.create', compact('cargos','empresas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'tipo_documento' => ['required', new Enum(TipoDocumento::class),],
        'numero_documento' => 'required|string|max:20|unique:trabajadores,numero_documento',
        'fecha_ingreso' => 'required|date',
        'email' => 'nullable|email|max:100|unique:trabajadores,email',
        'fecha_nacimiento' => 'nullable|date',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'persona_contacto' => 'nullable|string|max:100',
        'telefono_persona_contacto' => 'nullable|string|max:20',
        'cargo_id' => 'required|exists:cargos,id',
        'salario' => 'required|numeric|min:0',
        'aux_transporte' => 'nullable|numeric|min:0',
        'empresa_id' => 'required|exists:empresas,id',
    ]);

    Trabajador::create($validated);

    return redirect()
        ->route('trabajadores.index')
        ->with('success', 'Trabajador creado correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(Trabajador $trabajador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargos = Cargo::all();
        $empresas = Empresa::all();
        $trabajador = Trabajador::findOrFail($id);
        return view('modules.trabajadores.create', compact('trabajador','cargos','empresas'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $request->validate([
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'tipo_documento' => ['required', new Enum(TipoDocumento::class),],
        'numero_documento' => ['required','string','max:20',Rule::unique('trabajadores')->ignore($trabajador->id),],
        'fecha_ingreso' => 'required|date',
        'email' => ['nullable','email','max:100',Rule::unique('trabajadores')->ignore($trabajador->id),],
        'fecha_nacimiento' => 'nullable|date',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'persona_contacto' => 'nullable|string|max:100',
        'telefono_persona_contacto' => 'nullable|string|max:20',
        'cargo_id' => 'required|exists:cargos,id',
        'salario' => 'required|numeric|min:0',
        'aux_transporte' => 'nullable|numeric|min:0',
        'empresa_id' => 'required|exists:empresas,id',
    ]);
        $trabajador->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'fecha_ingreso' => $request->fecha_ingreso,
            'email' => $request->email,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'persona_contacto' => $request->persona_contacto,
            'telefono_persona_contacto' => $request->telefono_persona_contacto,
            'cargo_id' => $request->cargo_id,
            'salario' => $request->salario,
            'aux_transporte' => $request->aux_transporte,
            'empresa_id' => $request->empresa_id,
            ]);

            return redirect()
            ->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trabajador = Trabajador::findOrFail($id);
        $trabajador->delete();
        return redirect()
            ->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }
}
