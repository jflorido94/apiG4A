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
            'buyer' => [
                'id' => $this->buyer->id,
                'nick' => $this->buyer->nick,
                'avatar' => $this->buyer->avatar,
            ],
            'product' => [
                'id' => $this->product->id,
                'tittle' => $this->product->title,
                'condition' => $this->product->condition->name,
            ],
            'seller' => [
                'id' => $this->seller->id,
                'title' => $this->seller->nick,
                'info' => $this->seller->avatar,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
