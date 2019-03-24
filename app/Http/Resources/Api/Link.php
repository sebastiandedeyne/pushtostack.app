<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class Link extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'url' => $this->url,
            'title' => $this->title,
            'stack_uuid' => $this->stack_uuid,
        ];
    }
}
