<?php

namespace App\Http\Resources\Social;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => optional($this->created_at)->format('Y-m-d H:i:s'),
            //If you rewrite it on React it will help you or other FE Framework
        ];
    }
}
