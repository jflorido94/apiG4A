<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => url($this->image),
            'price' => $this->price,
            'erased' => $this->erased,
            'owner' => [
                'id' => $this->user->id,
                'nick' => $this->user->nick,
                'avatar' => $this->user->avatar,
            ],
            'condition' => [
                'title' => $this->condition->name,
                'info' => $this->condition->description,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
