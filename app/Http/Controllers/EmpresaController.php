<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TiposDocumento;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('modules.empresa.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = null; // No hay empresa existente al crear una nueva
        $teams = Team::whereDoesntHave('empresa')->get();
        $tiposDocumento = TiposDocumento::all();

        return view('modules.empresa.create', compact('empresa', 'teams', 'tiposDocumento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id'            => 'required|exists:teams,id|unique:empresas,team_id',
            'razon_social'       => 'required|string|max:255',
            'nombre_comercial'   => 'nullable|string|max:255',
            'tipo_documento_id'  => 'required|exists:tipos_documentos,id',
            'numero_documento'   => 'required|integer|unique:empresas,numero_documento',
            'digito_verificacion'=> 'nullable|integer',
            'direccion'          => 'nullable|string|max:255',
            'telefono'           => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:255',
        ]);

        // Crear la empresa
        $Empresa = Empresa::create($validated);

            // 3. Redireccionar al index con un mensaje de éxito para AdminLTE
            return redirect()
                ->route('empresa.index')
                ->with('success', 'Empresa registrada correctamente.');
        }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        $empresa = Empresa::findOrFail($empresa->id);
        return view('modules.empresa.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Empresa $empresa)
    {
        $teams = Team::where(function ($query) use ($empresa) {
        $query->whereDoesntHave('empresa')
              ->orWhere('id', $empresa->team_id);
            })->get();
            $tiposDocumento = TiposDocumento::all();

            return view('modules.empresa.create', compact('empresa','teams', 'tiposDocumento'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Empresa $empresa)
    {
       $validated = $request->validate([
            'team_id' => [
                'required',
                'integer',
                'exists:teams,id',
                Rule::unique('empresas', 'team_id')->ignore($empresa->id),
            ],
            'razon_social' => 'required|string|max:255',
            'nombre_comercial' => 'nullable|string|max:255',
            'tipo_documento_id' => 'required|exists:tipos_documentos,id',
            'numero_documento' => [
                'required',
                'integer',
                Rule::unique('empresas', 'numero_documento')
                    ->ignore($empresa->id),
            ],
            'digito_verificacion' => 'nullable|integer',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

    $empresa->update($validated);

        // 4. Redireccionar a la lista general con un mensaje de éxito
        return redirect()
            ->route('empresa.index') // Redirige al nombre de tu ruta del listado principal
            ->with('success', 'Empresa actualizada correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Empresa $empresa)
    {
        // 1. Buscar la empresa (si no existe, lanza un error 404)
        $empresa = Empresa::findOrFail($empresa->id);

        // 2. Eliminar el registro
        $empresa->delete();

        // 3. Redireccionar al listado con un mensaje de éxito
        return redirect()
            ->route('empresa.index')
            ->with('success', 'La empresa ha sido eliminada correctamente.');
    }
}
