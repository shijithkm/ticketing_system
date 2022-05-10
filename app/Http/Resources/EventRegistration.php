<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class EventRegistration extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticket_id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ];
    }
}
