<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProyectoEvaluar extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'codigoProyecto' => $this->codigoProyecto,
            'proyectoConsecutivo'=> $this->proyectoConsecutivo,
            'proyectoTitulo'=> $this->proyectoTitulo,
            'codigoRegional'=> $this->codigoRegional,
            'nombreRegional'=> $this->nombreRegional,
            'codigoCentro'=> $this->codigoCentro,
            'nombreCentro'=> $this->nombreCentro,
            'lineaProgramaticaDescripcion'=> $this->lineaProgramaticaDescripcion,
            'mesa'=> $this->mesa,
            'laboratorio'=> $this->laboratorio,
            'laboratorioNombre'=> $this->laboratorioNombre,
            'responsableRegional'=> $this->responsableRegional,
            'evaluado'=> $this->evaluado,
        ];
    }
}
