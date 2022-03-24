<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Centro extends JsonResource
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
            'id' => $this->l_id,
            'Nombre' => $this->Nombre,
            //'responsableCentro' => $this->responsableCentro,
            //'subdirector_id' => $this->ResponsableCentro,

            // el que sirve  'ResponsableCentro' => $this->ResponsableCentro,
            'subdirector_id' => $this->ResponsableCentro,
            'name' => $this->name,
            'Descripcion' => $this->Descripcion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
