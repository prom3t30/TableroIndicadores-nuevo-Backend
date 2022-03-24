<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Pantalla;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pantalla as PantallaResource;
use App\Http\Resources\PantallaCollection;

class PantallaController extends Controller
{
    public function index()
    {
        $pantallas = Pantalla::all();
        return new PantallaCollection($pantallas);
    }

    public function indexById($id)
    {
        $pantallas = Pantalla::where('aplicacion_id', '=', $id)->get();

        return new PantallaCollection($pantallas);
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
        ]);
        $Pantalla = Pantalla::create($request->all());

        return (new PantallaResource($Pantalla))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new PantallaResource(Pantalla::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',

        ]);
        $Pantalla = Pantalla::where('id', '=', $request->id)->first();
        $Pantalla->update($request->all());
        $Pantalla = Pantalla::where('id', '=', $request->id)->first();
        return (new PantallaResource($Pantalla))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Pantalla = Pantalla::findOrFail($id);
        $Pantalla->delete();
        return response()->json("Eliminado", 204);
    }
}
