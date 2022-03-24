<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Privilegio extends JsonResource
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
            'estado' => $this->estado,
            'rol_id' => $this->rol_id,
            'pantalla_id' => $this->pantalla_id,
            'funcion_id' => $this->funcion_id,
            'aplicacion_id' => $this->aplicacion_id,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];toArray($request);
    }
}
