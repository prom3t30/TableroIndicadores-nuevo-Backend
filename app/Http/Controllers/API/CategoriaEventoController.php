<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\CategoriaEvento;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaEvento as CategoriaEventoResource;
use App\Http\Resources\CategoriaEventoCollection;

class CategoriaEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CategoriaEventoCollection(categoriaevento::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|max:200',
        ]);
        $CategoriaEvento = CategoriaEvento::create($request->all());
        return (new CategoriaEventoResource($CategoriaEvento))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $CategoriaEvento = CategoriaEvento::where('id', '=', $request->id)->first();
        $CategoriaEvento->update($request->all());
        $CategoriaEvento = CategoriaEvento::where('id', '=', $request->id)->first();
        return (new CategoriaEventoResource($CategoriaEvento))
            ->response()
            ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $CategoriaEvento = CategoriaEvento::findOrFail($id);
        $CategoriaEvento->delete();
        return response()->json("Eliminado", 204);
    }
}
