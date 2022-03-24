<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\EjecucionIndicador;
use App\Models\MetaPorLinea;
use App\Models\Indicadores;
use App\Models\DetalleEjecucionIndicador;
use App\Http\Controllers\Controller;
use App\Http\Resources\EjecucionIndicador as EjecucionIndicadorResource;
use App\Http\Resources\EjecucionIndicadorCollection;
use Illuminate\Support\Facades\Log;

class EjecucionIndicadorController extends Controller
{
    public function index()
    {
        return new EjecucionIndicadorCollection(EjecucionIndicador::all());
    }

    public function create(Request $request)
    {
        for ($i = 0; $i < 12; $i++) {
            $ejecucionIndicador = new EjecucionIndicador();
            $ejecucionIndicador->metaXLinea_id = $request[$i]["metaXLinea_id"];
            $ejecucionIndicador->year = $request[$i]["year"];
            $ejecucionIndicador->mes = $request[$i]["mes"];
            $ejecucionIndicador->valorejecucionesperada = $request[$i]["valorMetaEsperada"];
            $ejecucionIndicador->valorejecucionrealizada = $request[$i]["valorejecucionrealizada"];
            $ejecucionIndicador->estado = 1;
            $ejecucionIndicador->usuarioCreacionModificacion = $request[$i]["user"];
            $ejecucionIndicador->save();
        }
        return response()->json('ok', 202);
    }

    public function getById($id)
    {
        return new EjecucionIndicadorResource(EjecucionIndicador::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([

            'metaXLinea_id' => 'required',
            'year' => 'required',
            'mes' => 'required|max:15',
            'valorejecucionesperada' => 'required',
        ]);
        $ejecucionIndicador = EjecucionIndicador::where('id', '=', $request->id)->first();
        $ejecucionIndicador->update($request->all());
        $ejecucionIndicador = EjecucionIndicador::where('id', '=', $request->id)->first();
        return (new EjecucionIndicadorResource($ejecucionIndicador))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $ejecucionIndicador = EjecucionIndicador::findOrFail($id);
        $ejecucionIndicador->delete();
        return response()->json("Eliminado", 204);
    }

    public function metasEsperadasPormes(Request $request)
    {
        $id = EjecucionIndicador::where([
            ['mes', '=', $request->mes],
            ['valorejecucionesperada', '=', $request->valorejecucionesperada],
            ['valorejecucionrealizada', '=', $request->valorejecucionrealizada],
        ])->first();
        return response()->json($id, 202);
    }

    public function getInformationLine(Request $request)
    {
        $valores = EjecucionIndicador::select('valorejecucionesperada')->where([['mes', '=', $request->mes], ['year', '=', $request->year], ['metaXLinea_id', '=', $request->metaXLinea_id]])->first();
        return response()->json($valores, 202);
    }

    public function getMetasEsperadasPorLineaPorAnio(Request $request)
    {
        $valores = array(
            "metaPorLinea" => array(),
            "mes" => array(),
            "metaEjecutada" => array()
        );

        array_push($valores["metaPorLinea"], MetaPorLinea::where([['linea_id', '=', $request->lineaProgramatica], ['indicador_id', '=', $request->indicador], ['year', '=', $request->year]])->first());

        foreach ($request->meses as $mes) {
            array_push($valores["mes"], EjecucionIndicador::where([['mes', '=', $mes['mes']], ['year', '=', $request->year], ['metaXLinea_id', '=', $valores["metaPorLinea"][0]->id]])->orderby('created_at', 'DESC')->take(1)->first());
        }

        foreach ($valores["mes"] as $ids) {
            if (isset($ids)) {
                array_push($valores["metaEjecutada"], DetalleEjecucionIndicador::select('valorEjecucionRealizada', 'centro_id', 'id')->where([['ejecucionIndicador_id', '=', $ids->id]])->orderby('created_at', 'DESC')->take(1)->first());
            } else {
                array_push($valores["metaEjecutada"], null);
            }
        }
        Log::debug($valores);

        return response()->json($valores, 202);
    }

    public function getIndicadoresMetaLinea(Request $request)
    {

        $indicadores = array(
            'indicador' => null
        );
        $linea = $request->id;
        $metasPorLinea = MetaPorLinea::where([['linea_id', '=', $linea], ['year', '=', $request->year]])->get();
        foreach ($metasPorLinea as $item) {

            array_push($indicadores,  Indicadores::where([['id', '=', $item["indicador_id"]]])->get());
        }
        return response()->json($indicadores, 200);
    }
}
