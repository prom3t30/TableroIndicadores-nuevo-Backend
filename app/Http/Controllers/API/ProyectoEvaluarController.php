<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProyectoEvaluar;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProyectoEvaluar as ProyectoEvaluarResource;
use App\Http\Resources\ProyectoEvaluarCollection;


class ProyectoEvaluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProyectoEvaluarCollection(ProyectoEvaluar::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ProyectoEvaluar = ProyectoEvaluar::create($request->all());
        return (new ProyectoEvaluarResource($ProyectoEvaluar))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProyectoEvaluarResource(ProyectoEvaluar::findOrFail($id));
    }

    /**
     * Busca los centros asociados al usuario que no esten evaluados.
     *
     * @param  int  $centro
     * @return \Illuminate\Http\Response
     */
    public function centro($codigoCentro)
    {
        $ProyectoEvaluarUserCentro = ProyectoEvaluar::where([['codigoCentro', '=', $codigoCentro], ['evaluado', '=', 0]])
            ->orderBy('nombreRegional', 'ASC')->get();
        return new ProyectoEvaluarCollection($ProyectoEvaluarUserCentro);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Actualiza, marca chekeado o evaluado el proyecto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $request->validate([
            'codigoProyecto' => 'required|max:255',
            'proyectoConsecutivo' => 'required|max:255',
            'evaluado' => 'required|max:2',
        ]);
        #Busca el proyecto por el codigo proyecto consecutivo.
        $ProyectoEvaluar = ProyectoEvaluar::where('proyectoConsecutivo', '=', $request->proyectoConsecutivo)->first();

        #Realiza la operacion de chequear como evaluado actualizandolo.
        $ProyectoEvaluar->where('codigoProyecto',  $request->codigoProyecto)
            ->update(['evaluado' =>  $request->evaluado]);

        $ProyectoEvaluar = ProyectoEvaluar::where('codigoProyecto', '=', $request->codigoProyecto)->first();

        return (new ProyectoEvaluarResource($ProyectoEvaluar))
            ->response()
            ->setStatusCode(202, 'El proyecto se evaluo satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $ProyectoEvaluar = ProyectoEvaluar::findOrFail($id);
        $ProyectoEvaluar->delete();
        return response()->json("Eliminado", 204);
    }
}
