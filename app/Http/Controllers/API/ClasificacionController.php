<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Clasificacion;
use App\Http\Controllers\Controller;
use App\Http\Resources\Clasificacion as ClasificacionResource;
use App\Http\Resources\ClasificacionCollection;

class ClasificacionController extends Controller
{
    public function index()
    {
        return new ClasificacionCollection(Clasificacion::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:300',
            'Descripcion' => 'max:500',
        ]);
        $clasificacion = Clasificacion::create($request->all());
        return (new ClasificacionResource($clasificacion))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new ClasificacionResource(Clasificacion::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:300',
            'Descripcion' => 'max:500',
        ]);
        $clasificacion = Clasificacion::where('id', '=', $request->id)->first();
        $clasificacion->update($request->all());
        $clasificacion = Clasificacion::where('id', '=', $request->id)->first();
        return (new ClasificacionResource($clasificacion))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $clasificacion = Clasificacion::findOrFail($id);
        $clasificacion->delete();
        return response()->json("Eliminado", 204);
    }
}
