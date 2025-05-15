<?php

namespace App\Http\Resources\Person;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active
        ];
    }
}
