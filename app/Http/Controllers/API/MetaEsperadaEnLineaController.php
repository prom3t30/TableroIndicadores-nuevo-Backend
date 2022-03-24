<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\EjecucionIndicador;
use App\Models\Indicadores;
use App\Models\MetaPorLinea;
use App\Models\MetaEsperadaEnLinea;
use App\Http\Controllers\Controller;
use App\Http\Resources\MetaEsperadaEnLinea as MetaEsperadaEnLineaResource;
use App\Http\Resources\MetaEsperadaEnLineaCollection;
use Illuminate\Support\Facades\Log;

class MetaEsperadaEnLineaController extends Controller
{
    public function index()
    {
        return new MetaEsperadaEnLineaCollection(MetaEsperadaEnLinea::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            'metaXLinea_id' => 'required',
            'year' => 'required',
            'mes' => 'required|max:15',
            'valorejecucionesperada' => 'required',

        ]);
        $MetaEsperadaEnLinea = MetaEsperadaEnLinea::create($request->all());
        return (new MetaEsperadaEnLineaResource($MetaEsperadaEnLinea))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new MetaEsperadaEnLineaResource(MetaEsperadaEnLinea::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'metaXLinea_id' => 'required',
            'year' => 'required',
            'mes' => 'required|max:15',
            'valorejecucionesperada' => 'required',

        ]);
        $MetaEsperadaEnLinea = MetaEsperadaEnLinea::where('id', '=', $request->id)->first();
        $MetaEsperadaEnLinea->update($request->all());
        $MetaEsperadadEnLinea = MetaEsperadaEnLinea::where('id', '=', $request->id)->first();
        return (new MetaEsperadaEnLineaResource($MetaEsperadaEnLinea))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $MetaEsperadaEnLinea = MetaEsperadaEnLinea::findOrFail($id);
        $MetaEsperadaEnLinea->delete();
        return response()->json("Eliminado", 204);
    }

    public function getMetasEsperadasPorLineaPorAnio(Request $request)
    {
        $valores = array(
            "metaPorLinea" => array(),
            "mes" => array()
        );

        array_push($valores["metaPorLinea"], MetaPorLinea::where([['linea_id', '=', $request->lineaProgramatica], ['indicador_id', '=', $request->indicador], ['year', '=', $request->year]])->first());

        foreach ($request->meses as $mes) {
            array_push($valores["mes"], EjecucionIndicador::select('valorejecucionesperada', 'valorejecucionrealizada')->where([['mes', '=', $mes['mes']], ['year', '=', $request->year], ['metaXLinea_id', '=', $valores["metaPorLinea"][0]->id]])->orderby('created_at', 'DESC')->take(1)->first());
        }

        return response()->json($valores, 202);
    }

    public function getIndicadoresMetaLinea(Request $request)
    {

        $indicadores = array(
            'indicador' => null
        );
        $linea = $request->id;
        $metasPorLinea = MetaPorLinea::where([['linea_id', '=', $linea], ['year', '=', $request->year], ['metaLinea', '>', 0]])->get();
        foreach ($metasPorLinea as $item) {

            array_push($indicadores,  Indicadores::where([['id', '=', $item["indicador_id"]], ['estado', '=', 1]])->get());
        }
        return response()->json($indicadores, 200);
    }

    public function valorMetaEsperada(Request $request)
    {
        $valorejecucucionesperada = EjecucionIndicador::all();
        return response()->json($valorejecucucionesperada, 202);
    }
}
