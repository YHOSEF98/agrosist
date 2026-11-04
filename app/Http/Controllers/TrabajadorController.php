<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\Cargo;
use App\Models\TiposDocumento;
use App\Models\Empresa;
use App\Models\Team;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TrabajadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $current_team)
    {
        $trabajadores = Trabajador::all();
        return view('modules.trabajadores.index', compact('trabajadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $current_team)
    {
        $trabajador = null;
        $tipos_documento = TiposDocumento::all();
        $cargos = Cargo::all();
        $teams = Auth::user()->teams;
        return view('modules.trabajadores.create', compact('trabajador','tipos_documento','cargos','teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( string $current_team, Request $request)
{
    $validated = $request->validate([
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'tipo_documento_id' => 'required|exists:tipos_documentos,id',
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
        'estatus' => 'required|string|in:Activo,Inactivo',
        'team_id' => 'required|exists:teams,id',
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
    public function edit(string $current_team, Trabajador $trabajador)
    {
        $cargos = Cargo::all();
        $tipos_documento = TiposDocumento::all();
        $teams = Auth::user()->teams;
        return view('modules.trabajadores.create', compact('trabajador','cargos','tipos_documento','teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Trabajador $trabajador)
    {
        $validated = $request->validate([
        'nombres' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'tipo_documento_id' => 'required|exists:tipos_documentos,id',
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
        'team_id' => 'required|exists:teams,id',
    ]);
        $trabajador->update($validated);

            return redirect()
            ->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Trabajador $trabajador)
    {
        $trabajador->delete();
        return redirect()
            ->route('trabajadores.index')
            ->with('success', 'Trabajador eliminado correctamente.');
    }
}
