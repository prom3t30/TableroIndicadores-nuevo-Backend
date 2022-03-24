<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AjusteMetaGlobal extends JsonResource
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
            'id' => $this->id,
            'indicador' => $this->Indicador,
            'metaOriginal' => $this->metaOriginal,
            'metaAjustado' => $this->metaAjustado,
            'fechaCambio' => $this->fechaCambio,
            'aprobacion' => $this->aprobacion,
            'fechaCreacion' => $this->fechaCreacion,
            'fechaUltimaModificacion' => $this->fechaUltimaModificacion,
            'usuarioCreacion' => $this->usuarioCreacion,
            'usuarioModificacion' => $this->usuarioModificacion,
            'estado' => $this->estado,
            'year'=> $this->year,
            'deleted_at' => $this->deleted_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
