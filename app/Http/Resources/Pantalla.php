<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pantalla extends JsonResource
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
            'Nombre' => $this->Nombre,
            'Descripcion' => $this->Descripcion,
            'aplicacion_id' => $this->aplicacion_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'aplicacion' => $this->aplicacion
        ];

    }
}
