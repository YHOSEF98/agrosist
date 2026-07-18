<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

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
        return view('modules.empresa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos que vienen del formulario
        $request->validate([
                'nombre' => 'required|string|max:255|unique:empresas,nombre',
                // El NIT suele ser único. Si manejas DV (Dígito de verificación), max:15 está perfecto.
                'nit'    => 'required|string|max:15|unique:empresas,nit',
            ], [
                // Mensajes personalizados en español
                'nombre.required' => 'El nombre de la empresa es obligatorio.',
                'nombre.unique'   => 'Ya existe una empresa registrada con ese nombre.',
                'nit.required'    => 'El NIT es obligatorio para el registro legal.',
                'nit.unique'      => 'Este NIT ya se encuentra registrado en el sistema.',
            ]);

            // 2. Crear el registro en la base de datos
            Empresa::create([
                'nombre' => $request->nombre,
                'nit'    => $request->nit,
            ]);

            // 3. Redireccionar al index con un mensaje de éxito para AdminLTE
            return redirect()
                ->route('empresa')
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
    public function edit(Request $request)
    {
        $empresa = Empresa::findOrFail($request->id);
        return view('modules.empresa.create', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:empresas,nombre,' . $empresa->id,
            'nit'    => 'required|string|max:15|unique:empresas,nit,' . $empresa->id,
        ], [
            'nombre.required' => 'El nombre de la empresa es obligatorio.',
            'nombre.unique'   => 'Ya existe otra empresa registrada con ese nombre.',
            'nit.required'    => 'El NIT es obligatorio.',
            'nit.unique'      => 'Este NIT ya pertenece a otra empresa.',
        ]);

        // 3. Actualizar el registro usando asignación masiva ($fillable)
        $empresa->update([
            'nombre' => $request->nombre,
            'nit'    => $request->nit,
        ]);

        // 4. Redireccionar a la lista general con un mensaje de éxito
        return redirect()
            ->route('empresa') // Redirige al nombre de tu ruta del listado principal
            ->with('success', 'Empresa actualizada correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Buscar la empresa (si no existe, lanza un error 404)
        $empresa = Empresa::findOrFail($id);

        // 2. Eliminar el registro
        $empresa->delete();

        // 3. Redireccionar al listado con un mensaje de éxito
        return redirect()
            ->route('empresa')
            ->with('success', 'La empresa ha sido eliminada correctamente.');
    }
}
