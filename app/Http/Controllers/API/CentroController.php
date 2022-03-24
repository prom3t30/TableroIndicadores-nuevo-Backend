<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Centro;
use App\Http\Controllers\Controller;
use App\Http\Resources\Centro as CentroResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CentroCollection;

class CentroController extends Controller
{
    public function index()
    {
        return new CentroCollection(DB::table('centros')
            ->where('centros.deleted_at', '=', null)
            ->select('centros.id as l_id', 'centros.*', 'users.*')
            ->leftJoin('users', 'centros.responsableCentro', '=', 'users.id')
            ->get());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
            'ResponsableCentro' => 'required',
        ]);
        $Centro = Centro::create($request->all());
        return (new CentroResource($Centro))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new CentroResource(Centro::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $Centro = Centro::where('id', '=', $request->id)->first();
        $Centro->update($request->all());
        $Centro = Centro::where('id', '=', $request->id)->first();
        return (new CentroResource($Centro))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Centro = Centro::findOrFail($id);
        $Centro->delete();
        return response()->json("Eliminado", 204);
    }
}
