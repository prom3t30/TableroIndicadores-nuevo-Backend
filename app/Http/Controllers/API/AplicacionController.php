<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Aplicacion;
use App\Http\Controllers\Controller;
use App\Http\Resources\Aplicacion as AplicacionResource;
use App\Http\Resources\AplicacionCollection;

class AplicacionController extends Controller
{
    public function index()
    {
        return new AplicacionCollection(Aplicacion::all());
    }
    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
        ]);
        $Aplicacion = Aplicacion::create($request->all());
        return (new AplicacionResource($Aplicacion))
            ->response()
            ->setStatusCode(201);
    }
    public function getById($id)
    {
        return new AplicacionResource(Aplicacion::findOrFail($id));
    }
    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
        ]);
        $Aplicacion = Aplicacion::where('id', '=', $request->id)->first();
        $Aplicacion->update($request->all());
        $Aplicacion = Aplicacion::where('id', '=', $request->id)->first();
        return (new AplicacionResource($Aplicacion))
            ->response()
            ->setStatusCode(202);
    }
    public function delete($id)
    {
        $Aplicacion = Aplicacion::findOrFail($id);
        $Aplicacion->delete();
        return response()->json("Eliminado", 204);
    }
}
