<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\AjusteMetaGlobal;
use App\Models\IndicadorMetaAno;
use App\Http\Controllers\Controller;
use App\Http\Resources\AjusteMetaGlobal as AjusteMetaGlobalResource;

class AjusteMetaGlobalController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'indicador_id' => 'required',
            'metaOriginal' => 'required',
            'metaAjustado' => 'required',
            'aprobacion' => 'required',
            'year' => 'required'
        ]);
        $AjusteMetaGlobal = AjusteMetaGlobal::create($request->all());
        $indicadores = IndicadorMetaAno::where([['indicador_id', '=',  $request->indicador_id], ['year', '=', $request->year]])->first();
        $indicadores->metaGlobal = $request->metaAjustado;
        $indicadores->save();
        return (new AjusteMetaGlobalResource($AjusteMetaGlobal))
            ->response()
            ->setStatusCode(201);
    }
}
