<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Indicadores extends JsonResource
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
            'clasificacion_id' => $this->clasificacion_id,
            'categoria_id' => $this->categoria_id,
            'cliente_id' => $this->cliente_id,
            'plataforma_id' => $this->plataforma_id,
            'periodicidad_id' => $this->periodicidad_id,
            'unidad_id' => $this->unidad_id,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'usuarioCreacion' => $this->usuarioCreacion,
            'usuarioModificacion' => $this->usuarioModifacion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categoria' => $this->categoria,
            'clasificacion' => $this->clasificacion,
            'periodicidad' => $this->periodicidad

        ];
    }
}
