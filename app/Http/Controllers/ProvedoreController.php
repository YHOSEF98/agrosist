<?php

namespace App\Http\Controllers;

use App\Models\Provedore;
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
        return view('modules.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // 1. Validar los datos que vienen del formulario
        $request->validate([
                'razon_social' => 'required|string|max:255|unique:provedores,razon_social',
                'nombre_comercial' => 'nullable|string|max:255',
                'tipo_contribuyente' => 'required|string|max:255',
                'tipo_documento' => 'required|string|max:255',
                'numero_documento' => 'required|string|max:15|unique:provedores,numero_documento',
                'digito_verificacion' => 'nullable|string|max:1',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'es_cliente' => 'nullable|boolean',
            ], [
                // Mensajes personalizados en español
                'razon_social.required' => 'La razón social de la empresa es obligatoria.',
                'razon_social.unique'   => 'Ya existe una empresa registrada con esa razón social.',
                'numero_documento.required' => 'El número de documento es obligatorio.',
                'numero_documento.unique' => 'Ya existe una empresa registrada con ese número de documento.',
                'digito_verificacion.unique' => 'Ya existe una empresa registrada con ese dígito de verificación.',
            ]);

            // 2. Crear el registro en la base de datos
            Provedore::create([
                'razon_social' => $request->razon_social,
                'nombre_comercial' => $request->nombre_comercial,
                'tipo_contribuyente' => $request->tipo_contribuyente,
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'digito_verificacion' => $request->digito_verificacion,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'es_cliente' => $request->es_cliente ?? false,
            ]);

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
    public function edit(string $id)
    {
        $proveedor = Provedore::findOrFail($id);
        return view('modules.proveedores.create', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proveedor = Provedore::findOrFail($id);

        $request->validate([
                'razon_social' => 'required|string|max:255|unique:empresas,razon_social,' . $proveedor->id,
                'nombre_comercial' => 'nullable|string|max:255',
                'tipo_contribuyente' => 'required|string|max:255',
                'tipo_documento' => 'required|string|max:255',
                'numero_documento' => 'required|string|max:15|unique:empresas,numero_documento,' . $proveedor->id,
                'digito_verificacion' => 'nullable|string|max:1',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'es_cliente' => 'nullable|boolean',
            ], [
                // Mensajes personalizados en español
                'razon_social.required' => 'La razón social de la empresa es obligatoria.',
                'razon_social.unique'   => 'Ya existe una empresa registrada con esa razón social.',
                'numero_documento.required' => 'El número de documento es obligatorio.',
                'numero_documento.unique' => 'Ya existe una empresa registrada con ese número de documento.',
                'digito_verificacion.unique' => 'Ya existe una empresa registrada con ese dígito de verificación.',
            ]);

        // 3. Actualizar el registro usando asignación masiva ($fillable)
        $proveedor->update([
            'razon_social' => $request->razon_social,
            'nombre_comercial' => $request->nombre_comercial,
            'tipo_contribuyente' => $request->tipo_contribuyente,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'digito_verificacion' => $request->digito_verificacion,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'es_cliente' => $request->es_cliente ?? false,
        ]);

        // 4. Redireccionar a la lista general con un mensaje de éxito
        return redirect()
            ->route('proveedores.index') // Redirige al nombre de tu ruta del listado principal
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedore = Provedore::findOrFail($id);
        $proveedore->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
