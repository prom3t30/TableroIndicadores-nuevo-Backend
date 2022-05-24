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


use Illuminate\Support\Facades\DB;

// modelo para poder llamr la tabal metalineacentro
use App\Models\MetaLineaCentro;

//modelo centro
use App\Models\Centro;


// modelo usuario
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

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


    // ----------------- Mi funcion  ----------------------------- //
    public function getMetasEsperadasPorLineaPorAnioPorCentro(Request $request)
    {

        //lnea programatica
        $linProgramatica = $request->lineaProgramatica;
        //var_dump($linProgramatica);

        //usuario
        $usuario =  $request->usu;
        //ar_dump($usuario);

        // id Usuario
        $id = $request->ides;
        //var_dump($id);

        // año
        $year = $request->year;

        // indicador
        $indicador = $request->getIndicadoresMetaLinea;

        // id del centro
        $IDCENTRO = DB::table('centros')
            ->select('id')
            ->where('ResponsableCentro', '=', $id)
            ->first();
        //var_dump($IDCENTRO);

        // convertimos el objeto anterior en un arreglo para poderlo pasar al selecte
        // siguiente que nos trae  las metas por linea por centro y por el id del centro
        $IDCENTRO = json_decode(json_encode($IDCENTRO), true);
        //var_dump($IDCENTRO);



        $idMetalineaCentro = DB::table('metalineacentro')
            ->join('centros', 'metalineacentro.centro_id', '=', 'centros.id')
            ->select('metalineacentro.metaxLinea_id')
            ->where('metalineacentro.centro_id', '=', $IDCENTRO)
            ->where('metalineacentro.metaxLinea_id', '=', $linProgramatica)
            ->get();
        //var_dump($idMetalineaCentro);

        $idMetLinCetr = json_decode(json_encode($idMetalineaCentro), true);
        //var_dump($idMetLinCetr);


        $ejecucion = DB::table('ejecucionmetacentro')
            ->select('ejecucionmetacentro.*')
            ->where('metaLineaCentro_id', '=', $idMetLinCetr)
            ->get();
        //var_dump($ejecucion);


        $acumE = DB::table('ejecucionmetacentro')
            ->select('ejecucionmetacentro.valorejecucionrealizada')
            ->where('metaLineaCentro_id', '=', $idMetLinCetr)
            ->Sum('valorejecucionrealizada');

        // SELECIONAR NOMBRE DE LA LINEA PROGRAMATICA
        $LinProgr = DB::table('lineaprogramatica')
            ->select('lineaprogramatica.Nombre')
            ->where('lineaprogramatica.id', '=', $linProgramatica)
            ->get();


        // funcional -------------------------------------
        $response = DB::table('metalineacentro')
            ->join('centros', 'metalineacentro.centro_id', '=', 'centros.id')
            ->select('metalineacentro.*', 'centros.*', 'centros.id as idCentro')
            ->where('metalineacentro.centro_id', '=', $IDCENTRO)
            ->where('metalineacentro.metaxLinea_id', '=', $linProgramatica)
            ->get();
        //var_dump($response);

        return response()->json([$response, $ejecucion, $acumE, $LinProgr], 200);
    }

    // ----------------- FIN Mi funcion  ----------------------------- //


    public function ejecucionPorLineaPorCentro(Request $request)
    {

        $this->validate($request, [
            'ejecucion' => 'required',
            'url' => 'required'

        ]);

        /*         $id = $request->id;
        var_dump($id);
        $eje = $request->ejecucionEne;
        var_dump($eje);

        $mes = $request->mes;
        var_dump($mes);

        $urlEne = $request->urlEne;
        var_dump($urlEne); */


        $metaxLinea_id = $request->metaxLinea_id;
        $year = $request->year;
        $mes = $request->mes;
        $eje = $request->ejecucion;
        $url = $request->url;





        $valorBtn = $request->valorBtn;
        //var_dump($valorBtn);



        DB::table('ejecucionmetacentro')->insert([
            'metaLineaCentro_id' => $metaxLinea_id,
            'year' => $year,
            'mes' => $mes,
            'valorejecucionrealizada' => $eje,
            'link' => $url,

        ]);

        //


    }

    public function ejecucionPorLineaPorCentroPorSub(Request $request)
    {
        $request->validate([
            'valorejecucionrealizada' => 'required',
            'link' => 'required|max:500',
        ]);


        // Editamos la meta del mes segun si ID de la tabla ejecucionmetacentro
        $Editar = DB::table('ejecucionmetacentro')
            ->select('ejecucionmetacentro.id')
            ->where('ejecucionmetacentro.id', '=', $request->id)
            ->update($request->all());

        return response()->json($Editar, 200);
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
