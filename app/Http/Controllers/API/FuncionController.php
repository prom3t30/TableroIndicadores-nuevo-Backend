<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Funcion;
use App\Http\Controllers\Controller;
use App\Http\Resources\Funcion as FuncionResource;
use App\Http\Resources\FuncionCollection;

class FuncionController extends Controller
{
    public function index()
    {
        return new FuncionCollection(Funcion::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'required|max:500',
        ]);
        $Funcion = Funcion::create($request->all());
        return (new FuncionResource($Funcion))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new FuncionResource(Funcion::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'required|max:500'
        ]);
        $Funcion = Funcion::where('id', '=', $request->id)->first();
        $Funcion->update($request->all());
        $Funcion = Funcion::where('id', '=', $request->id)->first();
        return (new FuncionResource($Funcion))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Funcion = Funcion::findOrFail($id);
        $Funcion->delete();
        return response()->json("Eliminado", 204);
    }
}
