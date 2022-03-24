<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Privilegio;
use App\Http\Controllers\Controller;
use App\Http\Resources\Privilegio as PrivilegioResource;
use App\Http\Resources\PrivilegioCollection;

class PrivilegioController extends Controller
{
    public function index()
    {
        return new PrivilegioCollection(Privilegio::all());
    }

    public function create(Request $request)
    {
        $Privilegio = Privilegio::create($request->all());
        return (new PrivilegioResource($Privilegio))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new PrivilegioResource(Privilegio::findOrFail($id));
    }

    public function getPrivilegiosByAplicacionIdPantallaIdRolId($aplicacionId, $pantallaId, $rolId)
    {
        $privilegios = Privilegio::where(
            [
                ['aplicacion_id', '=', $aplicacionId],
                ['pantalla_id', '=', $pantallaId],
                ['rol_id', '=', $rolId]
            ]
        )->get();
        return new PrivilegioCollection($privilegios);
    }

    public function setPrivilegios(Request $request)
    {
        $privilegios = Privilegio::where(
            [
                ['aplicacion_id', '=', $request->aplicacionId],
                ['pantalla_id', '=', $request->pantallaId],
                ['rol_id', '=', $request->rolId]
            ]
        )->get();
        foreach ($privilegios as &$privilegio) {
            $privilegio->estado = false;
            $privilegio->save();
        }
        $aplicacionId = $request->aplicacionId;
        $pantallaId = $request->pantallaId;
        $rolId = $request->rolId;
        $privilegios = $request->privilegios;
        $privilegiosArray = explode(",", $privilegios);
        foreach ($privilegiosArray as &$privilegioItem) {
            $privilegios = Privilegio::where(
                [
                    ['aplicacion_id', '=', $aplicacionId],
                    ['pantalla_id', '=', $pantallaId],
                    ['rol_id', '=', $rolId],
                    ['funcion_id', '=', $privilegioItem]
                ]
            )->get();
            if (count($privilegios) == 0) {
                $privilegio = new Privilegio;
                $privilegio->pantalla_id = $pantallaId;
                $privilegio->aplicacion_id = $aplicacionId;
                $privilegio->rol_id = $rolId;
                $privilegio->funcion_id = $privilegioItem;
                $privilegio->estado = true;
                $privilegio->save();
            } else {
                $privilegios[0]->estado = true;
                $privilegios[0]->save();
            }
        }
        return response()->json("OK", 200);
    }

    public function update(Request $request)
    {
        $Privilegio = Privilegio::where('id', '=', $request->id)->first();
        $Privilegio->update($request->all());
        $Privilegio = Privilegio::where('id', '=', $request->id)->first();
        return (new PrivilegioResource($Privilegio))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $Privilegio = Privilegio::findOrFail($id);
        $Privilegio->delete();
        return response()->json("Eliminado", 204);
    }
}
