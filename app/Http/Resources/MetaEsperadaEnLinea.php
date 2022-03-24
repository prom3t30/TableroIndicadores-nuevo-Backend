<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MetaEsperadaEnLinea extends JsonResource
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
            'metaXLinea_id' =>$this->metaXLinea_id,
            'year' => $this->year,
            'mes' => $this->mes,
            'valorejecucionesperada' => $this->valorejecucionesperada,

        ];
    }
}
