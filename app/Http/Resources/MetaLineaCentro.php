<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MetaLineaCentro extends JsonResource
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
            'id' => $this->id,#
            'metaxLinea_id' => $this->metaxLinea_id,#
            'centro_id' => $this->centro_id,#
            'metaCentro' => $this->metaCentro,
            'saved' => $this->saved,
            'usuarioCreacion' => $this->usuarioCreacion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
