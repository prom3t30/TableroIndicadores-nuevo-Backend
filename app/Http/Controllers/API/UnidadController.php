<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Unidad;
use App\Http\Controllers\Controller;
use App\Http\Resources\Unidad as UnidadResource;
use App\Http\Resources\UnidadCollection;

class UnidadController extends Controller
{
    public function index()
    {
        return new UnidadCollection(Unidad::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $Unidad = Unidad::create($request->all());
        return (new UnidadResource($Unidad))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new UnidadResource(Unidad::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $Unidad = Unidad::where('id', '=', $request->id)->first();
        $Unidad->update($request->all());
        $Unidad = Unidad::where('id', '=', $request->id)->first();
        return (new UnidadResource($Unidad))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Unidad = Unidad::findOrFail($id);
        $Unidad->delete();
        return response()->json("Eliminado", 204);
    }
}
