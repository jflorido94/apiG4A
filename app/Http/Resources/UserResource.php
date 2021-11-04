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
            'avatar'    =>      $this->avatar,
            'email'     =>      $this->email,
            'wallet'    =>      $this->wallet->amount,
        ];
    }
}