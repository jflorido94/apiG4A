<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'request' => $this->request,
            'respond' => $this->respond,
            'is_warning' => $this->is_warning,
            'ban_reason' => [
                'id' => $this->user->id,
                'name' => $this->banReason->name,
                'rule' => $this->banReason->rule,
            ],
            'user' => [
                'id' => $this->user->id,
                'nick' => $this->user->nick,
                'avatar' => $this->user->avatar,
            ],
            'item_reported' => [
                'id' => $this->accusation->id,
                'user' => $this->accusation->user->nick,
                'item' => $this->accusation,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
