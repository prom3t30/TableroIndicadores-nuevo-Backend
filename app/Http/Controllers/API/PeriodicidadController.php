<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Periodicidad;
use App\Http\Controllers\Controller;
use App\Http\Resources\Periodicidad as PeriodicidadResource;
use App\Http\Resources\PeriodicidadCollection;

class PeriodicidadController extends Controller
{
    public function index()
    {
        return new PeriodicidadCollection(Periodicidad::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $Periodicidad = Periodicidad::create($request->all());
        return (new PeriodicidadResource($Periodicidad))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new PeriodicidadResource(Periodicidad::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $Periodicidad = Periodicidad::where('id', '=', $request->id)->first();
        $Periodicidad->update($request->all());
        $Periodicidad = Periodicidad::where('id', '=', $request->id)->first();
        return (new PeriodicidadResource($Periodicidad))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Periodicidad = Periodicidad::findOrFail($id);
        $Periodicidad->delete();
        return response()->json("Eliminado", 204);
    }
}
