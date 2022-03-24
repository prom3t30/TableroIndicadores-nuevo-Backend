<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\IndicadorMetaAno;
use App\Http\Controllers\Controller;
use App\Http\Resources\IndicadoresCollection;
use App\Models\Indicadores;

class IndicadorMetaAnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    public function createMetaGlobalYear(Request $request)
    {
        $indicadorMetaAno =  IndicadorMetaAno::where([['indicador_id', '=', $request->id], ['year', '=', $request->year], ['metaGlobal', '=', null]])->first();
        if (isset($indicadorMetaAno)) {
            if ($request->metaGlobal > 0) {
                date_default_timezone_set("America/Bogota");
                $nowYear =  date("Y");
                if ($request->year == $nowYear) {
                    $indicadorMetaAno->usuarioCreacionMeta = $request->user;
                    $indicadorMetaAno->metaGlobal = $request->metaGlobal;
                    $indicadorMetaAno->save();
                    return response()->json('Meta global registrada con exito.', 202);
                } else {
                    return response()->json('El indicador no pertenece al presente año.', 503);
                }
            } else {

                return response()->json('La meta global debe ser mayor a 0', 503);
            }
        } else {
            return response()->json('El indicador ya tiene una meta global.', 503);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getYears()
    {
        $this->updateYear();
        $indicadoresMetaAno = IndicadorMetaAno::all();
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

    public function getIndicadoresYears($id)
    {
        $indicadorMetaAno = IndicadorMetaAno::where([['year', '=', $id]])->get();

        $indicadores = array(
            "metaGlobal" => array(),
            "indicadores" => array()

        );

        foreach ($indicadorMetaAno as $item) {
            array_push($indicadores["metaGlobal"], (IndicadorMetaAno::select('metaGlobal')->where([['indicador_id', '=', $item["indicador_id"]], ['year', '=', $id]])->first()));
            array_push($indicadores["indicadores"], (Indicadores::where([['id', '=', $item["indicador_id"]]])->first()));
        }
        $indicadores["indicadores"] = new IndicadoresCollection($indicadores["indicadores"]);
        return response()->json($indicadores);
    }


    public function getMetaGlobalById($id)
    {
        $metaGlobal = IndicadorMetaAno::select(['metaGlobal'])
            ->where([['indicador_id', '=', $id]])
            ->first();
        return response()->json($metaGlobal, 202);
    }

    public function getMetaGlobalByIndicador(Request $request)
    {
        $metaGlobal = IndicadorMetaAno::select('metaGlobal')
            ->where([['year', '=', $request->year], ['indicador_id', '=', $request->indicador_id]])->first();
        return response()->json($metaGlobal, 202);
    }


    private function updateYear()
    {
        date_default_timezone_set("America/Bogota");
        $nowYear =  date("Y");

        $years = IndicadorMetaAno::where([['year', '=', $nowYear]])->first();

        if (!isset($years)) {
            $oldYear = intval($nowYear) - 1;

            $update = IndicadorMetaAno::where([['year', '=', $oldYear]])->get();

            if (isset($update)) {
                foreach ($update as $item) {
                    $newYear = new IndicadorMetaAno();
                    $newYear->year = $nowYear;
                    $newYear->indicador_id = $item->indicador_id;
                    $newYear->metaGlobal = null;

                    $newYear->save();
                }
            }
        }
    }
}
