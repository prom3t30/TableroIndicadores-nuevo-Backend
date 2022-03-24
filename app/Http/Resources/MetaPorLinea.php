<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MetaPorLinea extends JsonResource
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
            'indicador_id' => $this->indicador_id,
            'linea_id' => $this->linea_id,
            'metaLinea' => $this->metaLinea,
            'estado' => $this->estado,
            'year' => $this->year
        ];
    }
}
