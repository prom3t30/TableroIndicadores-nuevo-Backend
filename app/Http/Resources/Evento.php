<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Evento extends JsonResource
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
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'ubicacion' => $this->ubicacion,
            'link' => $this->link,
            'poster' => $this->poster,
            'estado' => $this->estado,
            'fechaPublicacion' => $this->fechaPublicacion,
            'categoria' => $this->categoria,
            'delete_at' => $this->delete_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'userPublico' => $this->userPublico
        ];
    }
}
