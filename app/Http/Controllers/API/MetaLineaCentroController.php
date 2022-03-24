<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\MetaLineaCentro;
use App\Http\Controllers\Controller;
use App\Http\Resources\MetaLineaCentro as MetaLineaCentroResource;
use App\Http\Resources\MetaLineaCentroCollection;


class MetaLineaCentroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MetaLineaCentroCollection(MetaLineaCentro::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'mporcentro' => 'required',
            'metaxLinea_id' => 'required|max:500',
            'usuarioCreacion' => 'required',
        ]);

        $mpc = $request->mporcentro;

        foreach ($mpc as $iterador => $meta) {
            $i = $iterador;
            $MetaLineaCentro = new MetaLineaCentro();
            $MetaLineaCentro->centro_id = $mpc[$iterador]["centro"]["id"];  //Guarda el identificador unico del centro {num}
            $MetaLineaCentro->metaCentro = $mpc[$iterador]["metaCentro"];   //Guarda la meta del cetro {num}
            $MetaLineaCentro->saved = true; //confima que esta guardado {bolean}
            $MetaLineaCentro->metaXLinea_id = $request->metaxLinea_id;  //Guarda el identificador unico de la linea {num}
            $MetaLineaCentro->usuarioCreacion = $request->usuarioCreacion;  //Guarda el id del usuario que lo guardo {num}
            $MetaLineaCentro->save();   //Inserta el objeto en la base de datos.
        }
        //Código de respuesta de estado satisfactorio HTTP 200 OK indica que la solicitud ha tenido éxito.
        return response()->json("OK", 200);
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
        $request->validate([
            'Nombre' => 'required|max:255',
            'Descripcion' => 'max:500',
        ]);
        $MetaLineaCentro = MetaLineaCentro::where('id', '=', $request->id)->first();
        $MetaLineaCentro->update($request->all());
        $MetaLineaCentro = MetaLineaCentro::where('id', '=', $request->id)->first();
        return (new MetaLineaCentroResource($MetaLineaCentro))
            ->response()
            ->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}
