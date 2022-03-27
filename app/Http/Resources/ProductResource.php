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
            'price' => $this->price,
            'erased' => $this->erased,
            'owner' => [
                'id' => $this->user->id,
                'nick' => $this->user->nick,
                'votes'   => [
                    'count' => $this->user->votes->count(),
                    'average' => $this->user->votes->avg('stars')
                ],
                'avatar' => $this->user->avatar,
            ],
            'image' => $this->image,
            'condition' => new ConditionResource($this->condition),
            // 'tags' => TagResource::collection($this->tags),
            'created_at' => $this->created_at,
        ];
    }
}
