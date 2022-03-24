<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\User as Usuario;
use App\Models\Centro;
use App\Models\DetalleEjecucionIndicador;
use App\Models\EjecucionIndicador;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetalleEjecucionIndicador as DetalleEjecucionIndicadorResource;
use App\Http\Resources\DetalleEjecucionIndicadorCollection;

class DetalleEjecucionIndicadorController extends Controller
{
    public function index()
    {
        return new DetalleEjecucionIndicadorCollection(DetalleEjecucionIndicador::all());
    }
    public function create(Request $request)
    {
        $idEjecucion = 0;
        $detalleEjecucionIndicador =  new DetalleEjecucionIndicador();

        $getEjecucionIndicador = EjecucionIndicador::where([['id', '>', intval($request->id) - 1], ['id', '<', intval($request->id) + 12]])->get();

        foreach ($getEjecucionIndicador as $item) {
            $ejecucionIndicador = new EjecucionIndicador();
            $ejecucionIndicador->metaXLinea_id = $item['metaXLinea_id'];
            $ejecucionIndicador->year = $item['year'];
            $ejecucionIndicador->mes = $item['mes'];
            $ejecucionIndicador->valorejecucionesperada = $item['valorejecucionesperada'];
            if ($request->mes == $item['mes']) {
                $ejecucionIndicador->valorejecucionrealizada =  intval($item['valorejecucionrealizada']) + intval($request->metaEjecutada);
            } else {
                $ejecucionIndicador->valorejecucionrealizada =  $item['valorejecucionrealizada'];
            }

            $ejecucionIndicador->estado = 1;
            $ejecucionIndicador->usuarioCreacionModificacion = $request->user;
            $ejecucionIndicador->save();

            if ($request->mes == $item['mes']) {
                $idEjecucion = $ejecucionIndicador->id;
            }
        }

        $detalleEjecucionIndicador->ejecucionIndicador_id = $idEjecucion;
        $detalleEjecucionIndicador->centro_id = $request->centro_id;
        $detalleEjecucionIndicador->valorEjecucionRealizada = $request->metaEjecutada;
        $detalleEjecucionIndicador->user = $request->user;
        $detalleEjecucionIndicador->save();

        $detallesIndicadorId = DetalleEjecucionIndicador::where([['ejecucionIndicador_id', '=', $request->id]])->get();

        if (isset($detallesIndicadorId)) {
            foreach ($detallesIndicadorId as $key) {
                $saveDetalles = new DetalleEjecucionIndicador();
                $saveDetalles->ejecucionIndicador_id = $idEjecucion;
                $saveDetalles->centro_id = $key['centro_id'];
                $saveDetalles->valorEjecucionRealizada = $key['valorEjecucionRealizada'];
                $saveDetalles->user = $key['user'];
                $saveDetalles->save();
            }
        }

        return (new DetalleEjecucionIndicadorResource($detalleEjecucionIndicador))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new DetalleEjecucionIndicadorResource(DetalleEjecucionIndicador::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([

            'ejecucionIndicador_id' => 'required',
            'centro_id' => 'required',
            'valorEjecucionRealizada' => 'required',
        ]);
        $DetalleEjecucionIndicador = DetalleEjecucionIndicador::where('id', '=', $request->id)->first();
        $DetalleEjecucionIndicador->update($request->all());
        $DetalleEjecucionIndicador = DetalleEjecucionIndicador::where('id', '=', $request->id)->first();
        return (new DetalleEjecucionIndicadorResource($DetalleEjecucionIndicador))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $detalleEjecucionIndicador = DetalleEjecucionIndicador::findOrFail($id);
        $detalleEjecucionIndicador->delete();
        return response()->json("Eliminado", 204);
    }

    public function createDetalleGeneral(Request $request)
    {
        for ($i = 0; $i < 12; $i++) {
            $detalleEjecucionIndicador = new DetalleEjecucionIndicador();
            $detalleEjecucionIndicador->ejecucionIndicador_id = $request[$i]['id'];
            $detalleEjecucionIndicador->valorEjecucionRealizada = $request[$i]['metaEjecutada'];
            $detalleEjecucionIndicador->user = $request[$i]['user'];
            $detalleEjecucionIndicador->save();
        }

        return response()->json('Ok', 202);
    }

    public function getInforamtionByExecute(Request $request)
    {
        $valores = array(
            "detalleEjecucionIndicador" => array(),
            "user" => array(),
            "centro" => array()
        );
        array_push($valores["detalleEjecucionIndicador"], DetalleEjecucionIndicador::where([['ejecucionIndicador_id', '=', $request->id]])->get());
        foreach ($valores["detalleEjecucionIndicador"][0] as $item) {
            array_push($valores["user"], Usuario::select('name')->where([['id', '=', $item['user']]])->first());
            array_push($valores["centro"], Centro::select('nombre')->where([['id', '=', $item['centro_id']]])->first());
        }

        return response()->json($valores, 202);
    }
}
