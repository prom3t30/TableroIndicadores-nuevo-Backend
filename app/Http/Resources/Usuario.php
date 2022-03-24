<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Usuario extends JsonResource
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
            'name' => $this->name,
            'cargo' => $this->cargo,
            'email' => $this->email,
            'cedula' => $this->cedula,
            'remember_token' => $this->created_at,
            'estado' => $this->updated_at,
            'codigoCentro' => $this->codigoCentro || $this->centro,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'aplicaciones' => $this->aplicaciones
        ];
    }
}
