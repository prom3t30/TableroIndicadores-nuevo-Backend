<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cliente as ClienteResource;
use App\Http\Resources\ClienteCollection;

class ClienteController extends Controller
{
    public function index()
    {
        return new ClienteCollection(Cliente::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:300',
            'Descripcion' => 'max:500',
        ]);
        $Cliente = Cliente::create($request->all());
        return (new ClienteResource($Cliente))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new ClienteResource(Cliente::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:300',
        ]);
        $Cliente = Cliente::where('id', '=', $request->id)->first();
        $Cliente->update($request->all());
        $Cliente = Cliente::where('id', '=', $request->id)->first();
        return (new ClienteResource($Cliente))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Cliente = Cliente::findOrFail($id);
        $Cliente->delete();
        return response()->json("Eliminado", 204);
    }
}
