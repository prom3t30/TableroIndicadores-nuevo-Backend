<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Indicadores;
use App\Models\IndicadorMetaAno;
use App\Http\Controllers\Controller;
use App\Http\Resources\Indicadores as IndicadoresResource;
use App\Http\Resources\IndicadoresCollection;

class IndicadoresController extends Controller
{
    public function index()
    {
        $indicadores = Indicadores::all();

        return new IndicadoresCollection($indicadores);
    }

    public function createNewIndicador(Request $request)
    {
    }

    public function createNuevaMeta(Request $request)
    {
        $request->validate([
            'clasificacion_id' => 'required',
            'categoria_id' => 'required',
            'cliente_id' => 'required',
            'plataforma_id' => 'required',
            'periodicidad_id' => 'required',
            'unidad_id' => 'required',
            'descripcion' => 'max:500',
            'estado' => 'required',
            'usuarioCreacion' => 'max:500',
            'usuarioModificacion' => 'max:500'
        ]);
        $indicadores = Indicadores::create($request->all());
        $indicadorMetaAno = new IndicadorMetaAno();

        //Obtner la zona horaria
        date_default_timezone_set("America/Bogota");
        $nowYear =  date("Y");


        $indicadorMetaAno->year = $nowYear;
        $indicadorMetaAno->usuarioCreacionMeta = 0;
        $indicadorMetaAno->indicador_id = $indicadores->id;
        $indicadorMetaAno->save();

        return (new IndicadoresResource($indicadores))
            ->response()
            ->setStatusCode(201);
    }

    public function getById($id)
    {
        return new IndicadoresResource(Indicadores::findOrFail($id));
    }

    public function update(Request $request)
    {
        $request->validate([
            'clasificacion_id' => 'required',
            'categoria_id' => 'required',
            'cliente_id' => 'required',
            'plataforma_id' => 'required',
            'periodicidad_id' => 'required',
            'unidad_id' => 'required',
            'descripcion' => 'max:500',
            'metaGlobal' => 'required',
            'estado' => 'required',
            'usuarioCreacion' => 'max:500',
            'usuarioModificacion' => 'max:500',
        ]);
        $indicadores = Indicadores::where('id', '=', $request->id)->first();
        $indicadores->update($request->all());
        $indicadores = Indicadores::where('id', '=', $request->id)->first();
        return (new IndicadoresResource($indicadores))
            ->response()
            ->setStatusCode(202);
    }

    public function delete($id)
    {
        $indicadores = indicadores::findOrFail($id);
        $indicadores->delete();
        return response()->json("Eliminado", 204);
    }

    public function updateEstado(Request $request)
    {
        $request->validate([
            'estado' => 'required',
        ]);
        $indicadores = Indicadores::where('id', '=', $request->id)->first();
        $indicadores->estado = $request->estado;
        $indicadores->save();
        return (new IndicadoresResource($indicadores))
            ->response()
            ->setStatusCode(202);
    }
}
