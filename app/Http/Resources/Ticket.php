<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Ticket extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'ticket_type' => $this->ticket_type,
            'capacity' => $this->capacity,
            'price' => $this->price,
        ];
    }

    public function with($request) {
        return [
            'version' => '1.0.0',
        ];
    }
}
