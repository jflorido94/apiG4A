<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'amount' => $this->amount,
            'product' => [
                'id' => $this->product->id,
                'title' => $this->product->title,
                'condition' => $this->product->condition->name,
                'image' => $this->product->image,
            ],
            'seller' => [
                'id' => $this->seller->id,
                'nick' => $this->seller->nick,
                'avatar' => $this->seller->avatar,
            ],
            'buyer' => [
                'id' => $this->buyer->id,
                'nick' => $this->buyer->nick,
                'avatar' => $this->buyer->avatar,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
