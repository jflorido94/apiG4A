<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'stars' => $this->stars,
            'comment' => $this->comment,
            'user' => [
                'id' => $this->user->id,
                'nick' => $this->user()->nick,
                'avatar' => $this->user()->avatar,
            ],
            'transaction' => [
                'product' => [
                    'id' => $this->transaction->product->id,
                    'tittle' => $this->transaction->product->title,
                    'condition' => $this->transaction->product->condition->name,
                ],
                'seller' => [
                    'id' => $this->transaction->seller->id,
                    'tittle' => $this->transaction->seller->nick,
                    'condition' => $this->transaction->seller->avatar,
                ],
            ],
            'created_at' => $this->created_at,
        ];
    }
}
