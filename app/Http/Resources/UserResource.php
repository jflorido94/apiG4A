<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'        =>      $this->id,
            'nick'      =>      $this->nick,
            'name'      =>      $this->name,
            'surnames'  =>      $this->surnames,
            'dni'       =>      $this->dni,
            'email'     =>      $this->email,
            'erased'    =>      $this->erased,
            'wallet'    =>      [
                'amount'    => $this->wallet->amount,
            ],
            'products'  => ProductResource::collection($this->products),
            'average' => $this->votes->avg('stars'),
            'votes'   => ReviewResource::collection($this->votes),
            'sales' => [
                'count' => $this->sales->count(),
            ],
            'shoppings' => [
                'count' => $this->shoppings->count()
            ],
            'reviews' => [
                'count' => $this->reviews->count()
            ],
            'avatar'    =>      $this->avatar,
            ];
        }
    }

