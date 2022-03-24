<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Controllers\Controller;
use App\Http\Resources\Categoria as CategoriaResource;
use App\Http\Resources\CategoriaCollection;


class CategoriaController extends Controller
{
    public function index()
    {
        return new CategoriaCollection(Categoria::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $request->estado = true;
        $categoria = Categoria::create($request->all());
        return (new CategoriaResource($categoria))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new CategoriaResource(Categoria::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:300',
            'Descripcion' => 'max:500',
        ]);
        $categoria = Categoria::where('id', '=', $request->id)->first();
        $categoria->update($request->all());
        $categoria = Categoria::where('id', '=', $request->id)->first();
        return (new CategoriaResource($categoria))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json("Eliminado", 204);
    }
}
