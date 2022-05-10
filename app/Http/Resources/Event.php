<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Event extends Resource
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
            'title' => $this->title,
            'description' => $this->description,
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
        ];
    }

    // public function with($request) {
    //     return [
    //         'version' => '1.0.0',
    //     ];
    // }
}
