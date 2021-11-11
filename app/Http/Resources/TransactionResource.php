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
                'id' => $this->user->id,
                'nick' => $this->user->nick,
                'avatar' => $this->user->avatar,
            ],
            'product' => [
                'id' => $this->product->id,
                'tittle' => $this->product->title,
                'condition' => $this->product->condition->name,
            ],
            'state' => [
                'title' => $this->state->name,
                'info' => $this->state->description,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
