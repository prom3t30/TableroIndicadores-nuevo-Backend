<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EjecucionIndicador extends JsonResource
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
            'id'=>$this->id,
            'metaXLinea_id'=>$this->metaXLinea_id,
            'year'=>$this->year,
            'mes'=>$this->mes,
            'valorejecucionesperada'=>$this->valorejecucionesperada,
            'valorejecucionrealizada'=>$this->valorejecucionrealizada,
            'estado'=>$this->estado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
