<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\MetaPorLinea;
use App\Models\Lineaprogramatica;
use App\Models\AjusteMetaLinea;
use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPorLineaCollection;

class MetaPorLineaController extends Controller
{
    public function index()
    {
        return new MetaPorLineaCollection(MetaPorLinea::all());
    }

    public function setMetasXLinea(Request $Request)
    {
        date_default_timezone_set("America/Bogota");
        $nowYear =  date("Y");
        $Indicador_id = $Request->indicador_id;
        $metaXLinea = $Request->metaXLinea;
        $year = $Request->year;

        foreach ($metaXLinea as $item) {
            $metaPorLineaItem = MetaPorLinea::where([['indicador_id', '=', $Indicador_id], ['linea_id', '=', $item["value"]], ['year', '=', $year]])->first();

            if ($metaPorLineaItem != null) {
                $update = $metaPorLineaItem;



                if ($item["metaxlinea"] == null) {
                    $item["metaxlinea"] = 0;
                }
                $ajusteMetaLinea = new AjusteMetaLinea();
                $ajusteMetaLinea->metaXLinea_id = $metaPorLineaItem->id;
                $ajusteMetaLinea->metaOriginal = $update->metaLinea;
                $ajusteMetaLinea->metaAjustado =  $item["metaxlinea"] > 0 ? $item["metaxlinea"] : 0;
                $ajusteMetaLinea->year = $metaPorLineaItem->year;
                $ajusteMetaLinea->fechaCambioDate = now(); //date("Y/m/d");
                $ajusteMetaLinea->aprobacion = 1;
                $ajusteMetaLinea->usuarioModificacion = $Request->user;
                $ajusteMetaLinea->fechaCreacion = now(); //date("Y/m/d");
                $ajusteMetaLinea->estado = $item["selected"];
                $ajusteMetaLinea->save();

                $metaPorLineaItem->metaLinea = $item["metaxlinea"];
                $metaPorLineaItem->estado =  $item["selected"];
                $metaPorLineaItem->save();
            } else {
                $nuevoItem = new MetaPorLinea();
                $nuevoItem->metaLinea = $item["metaxlinea"];
                $nuevoItem->estado =  $item["selected"];
                $nuevoItem->indicador_id = $Indicador_id;
                $nuevoItem->linea_id = $item["value"];
                $nuevoItem->year = $nowYear;
                $nuevoItem->save();
            }
        }

        return response()->json("OK", 200);
    }

    public function getLineasXMeta(Request $request)
    {
        $Indicador_id = $request->id;

        $metasPorLineaItem = MetaPorLinea::where([['indicador_id', '=', $Indicador_id], ['year', '=', $request->year]]);

        if ($metasPorLineaItem == null) {
            //consultar todas las lineas
            $lineas = Lineaprogramatica::all();
            foreach ($lineas as $item) {
                $nuevoItem = new MetaPorLinea();
                $nuevoItem->metaLinea = 0;
                $nuevoItem->estado =  false;
                $nuevoItem->indicador_id = $Indicador_id;
                $nuevoItem->linea_id = $item->id;
                $nuevoItem->year = $item->year;
                $nuevoItem->save();
            }
            $metasPorLineaItem = MetaPorLinea::where([['indicador_id', '=', $Indicador_id], ['year', '=', $request->year]]);
        }
        return new MetaPorLineaCollection($metasPorLineaItem->get());
    }

    public function getYearsByLine(Request $request)
    {
        $indicadoresMetaAno = MetaPorLinea::where([['linea_id', '=', $request->linea_id]])->get();
        $years = array(
            0
        );
        $i = 0;
        foreach ($indicadoresMetaAno as $item) {
            if ($years[0] == 0) {
                $years[0] = $item['year'];
            } else {
                if ($years[$i] != $item['year']) {
                    array_push($years, $item['year']);
                    $i++;
                }
            }
        }
        return response()->json($years, 202);
    }

    public function getlineMeta(Request $request)
    {
        $metaLine = MetaPorLinea::select('metaLinea')->where([['indicador_id', '=', $request->indicador_id], ['year', '=', $request->year], ['linea_id', '=', $request->linea_id]])->first();

        return response()->json($metaLine, 202);
    }
}
