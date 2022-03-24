<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Http\Controllers\Controller;
use App\Http\Resources\Evento as EventoResource;
use App\Http\Resources\EventoCollection;

class EventoController extends Controller
{
    /**0
     * Muestra un listado del recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = config("rutaI.rutaImg");
        $event = Evento::all();
        return [new EventoCollection($event), $ruta];
    }

    public function consult()
    {
        // Mes actual
        $fechaActual = date('Y-m H:i:s');
        // Mes actual + 1 mes para finalizar.
        $fechaFinal = date("Y-m-d H:i:s", strtotime($fechaActual . "+ 1 month"));

        $ruta = config("rutaI.rutaImg");
        $eventFiltro = Evento::where('estado', 1)->whereBetween('fechaInicio', [$fechaActual, $fechaFinal])->orderBy('fechaInicio', 'ASC')->get();
        return [new EventoCollection($eventFiltro), $ruta];
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'id' => 'nullable',
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|max:600',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date',
            'categoria' => 'required|max:100',
        ]);
        if ($request['poster']) {
            $poster = $request['poster'];
            $imageInfo = explode(";base64,", $poster);
            $imgExt = str_replace('data:image/', '', $imageInfo[0]);
            $poster = str_replace(' ', '+', $imageInfo[1]);
            $imageName = time() . "." . $imgExt;
            $request['poster'] = $imageName;
            $ruta = config("rutaI.rutaBack") . $imageName;
            file_put_contents($ruta, base64_decode($poster));
        }

        $Evento = Evento::create($request->all());
        return (new EventoResource($Evento))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Muestra el recurso especificado por su id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        return new EventoResource(Evento::findOrFail($id));
    }

    /**
     * Actualiza el recurso especificado en el almacénacmiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Si la solicitud trae una imag actualizada.
        if ($request['poster']) {
            //Si la solicitud trae una imagen antigua borra la antigua.
            if ($request['imgOld']) {
                $poster_path = config("rutaI.rutaBack") . $request['imgOld'];
                if (file_exists($poster_path)) {
                    unlink($poster_path);
                }
            }
            $poster = $request['poster'];
            $imageInfo = explode(";base64,", $poster);
            $imgExt = str_replace('data:image/', '', $imageInfo[0]);
            $poster = str_replace(' ', '+', $imageInfo[1]);
            $imageName = time() . "." . $imgExt;
            $request['poster'] = $imageName;
            $ruta = config("rutaI.rutaBack") . $imageName;
            file_put_contents($ruta, base64_decode($poster));
        }

        $Evento = Evento::where('id', '=', $request->id)->first();
        $Evento->update($request->all());
        $Evento = Evento::where('id', '=', $request->id)->first();
        return (new EventoResource($Evento))
            ->response()
            ->setStatusCode(202);
    }

    /**
     *Retira el recurso especificado del almacenamiento por su id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $Evento = Evento::findOrFail($id);
        $poster_path = config("rutaI.rutaBack") . $Evento->poster;

        if (file_exists($poster_path)) {
            unlink($poster_path);
        }

        $Evento->delete();
        return response()->json("Eliminado", 204);
    }
}
