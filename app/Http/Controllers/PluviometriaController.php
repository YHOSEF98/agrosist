<?php

namespace App\Http\Controllers;

use App\Models\Pluviometria;
use Illuminate\Http\Request;

class PluviometriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pluviometrias = Pluviometria::all();
        return view('modules.pluviometria.index', compact('pluviometrias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pluviometria $pluviometria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pluviometria $pluviometria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pluviometria $pluviometria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pluviometria $pluviometria)
    {
        //
    }
}
