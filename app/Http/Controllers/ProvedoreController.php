<?php

namespace App\Http\Controllers;

use App\Models\Provedore;
use App\Models\TiposDocumento;
use Illuminate\Http\Request;

class ProvedoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Provedore::all();
        return view('modules.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedore = null;
        $tiposDocumentos = TiposDocumento::all(); // Obtener todos los tipos de documentos
        $proveedor = null; // Inicializar la variable $proveedor como null
        return view('modules.proveedores.create', compact('proveedor', 'tiposDocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        
        // 1. Validar los datos que vienen del formulario
        $validated = $request->validate([
                'razon_social' => 'required|string|max:255|unique:provedores,razon_social',
                'nombre_comercial' => 'nullable|string|max:255',
                'tipo_documento_id' => 'required|exists:tipos_documentos,id',
                'numero_documento' => 'required|string|max:20|unique:provedores,numero_documento',
                'digito_verificacion' => 'nullable|string|max:1',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'es_cliente' => 'boolean',
            ], [
                // Mensajes personalizados en español
                'razon_social.required' => 'La razón social del proveedor es obligatoria.',
                'razon_social.unique'   => 'Ya existe una proveedor registrada con esa razón social.',
                'numero_documento.required' => 'El número de documento es obligatorio.',
                'numero_documento.unique' => 'Ya existe una proveedor registrada con ese número de documento.',
                'digito_verificacion.unique' => 'Ya existe una proveedor registrada con ese dígito de verificación.',
            ]);

            // 2. Crear el registro en la base de datos
            Provedore::create($validated);

            // 3. Redireccionar al index con un mensaje de éxito para AdminLTE
            return redirect()
                ->route('proveedores.index')
                ->with('success', 'Proveedor registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provedore $provedore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $current_team, Provedore $proveedore)
    {
        $tiposDocumentos = TiposDocumento::all();
        return view('modules.proveedores.create', compact('proveedore', 'tiposDocumentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Provedore $proveedore)
    {
        $validated = $request->validate([
                'razon_social' => 'required|string|max:255|unique:empresas,razon_social,' . $proveedore->id,
                'nombre_comercial' => 'nullable|string|max:255',
                'tipo_documento_id' => 'required|exists:tipos_documentos,id',
                'numero_documento' => 'required|string|max:20|unique:empresas,numero_documento,' . $proveedore->id,
                'digito_verificacion' => 'nullable|string|max:1',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'es_cliente' => 'boolean',
            ], [
                // Mensajes personalizados en español
                'razon_social.required' => 'La razón social de la empresa es obligatoria.',
                'razon_social.unique'   => 'Ya existe una empresa registrada con esa razón social.',
                'numero_documento.required' => 'El número de documento es obligatorio.',
                'numero_documento.unique' => 'Ya existe una empresa registrada con ese número de documento.',
            ]);

        // 3. Actualizar el registro usando asignación masiva ($fillable)
        $proveedore->update($validated);

        // 4. Redireccionar a la lista general con un mensaje de éxito
        return redirect()
            ->route('proveedores.index') // Redirige al nombre de tu ruta del listado principal
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $current_team, Provedore $proveedore)
    {
        try { // Asignar el proveedor a una variable para su uso posterior
            $proveedore->delete();

            return redirect()
                ->route('proveedores.index', [
                    'current_team' => $current_team
                ])
                ->with('success', 'Proveedor eliminado correctamente.');

        } catch (\Exception $e) {

            return redirect()
                ->route('proveedores.index', [
                    'current_team' => $current_team
                ])
                ->with('warning', $e->getMessage());
        }
    }
}
