<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Http\Controllers\Controller;
use App\Http\Resources\Rol as RolResource;
use App\Http\Resources\RolCollection;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function index()
    {
        return new RolCollection(Rol::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'required|max:500'
        ]);

        $Rol = Rol::create($request->all());

        return (new RolResource($Rol))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new RolResource(Rol::findOrFail($id));
    }

    public function getInfoPrivilegio($identifcador)
    {
        $consulta2 = DB::select(DB::raw(
            "SELECT
                rols.Nombre as rol,
                aplicaciones.Nombre as aplicacion,
                pantallas.Nombre as pantalla,
                funcions.Nombre as permiso
            FROM
                privilegios,
                aplicaciones,
                rols,
                pantallas,
                funcions
            WHERE
                rols.id = $identifcador AND
                privilegios.aplicacion_id = aplicaciones.id AND
                privilegios.rol_id = rols.id AND
                privilegios.pantalla_id = pantallas.id AND
                privilegios.funcion_id = funcions.id
                ORDER BY aplicacion ASC"
        ));
        return $consulta2;
    }

    public function update(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'required|max:500'
        ]);


        $Rol = Rol::where('id', '=', $request->id)->first();
        $Rol->update($request->all());
        $Rol = Rol::where('id', '=', $request->id)->first();

        return (new RolResource($Rol))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Rol = Rol::findOrFail($id);
        $Rol->delete();

        return response()->json("Eliminado", 204);
    }
}
