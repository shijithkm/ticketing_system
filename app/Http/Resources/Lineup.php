<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Lineup extends Resource
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
            'event_id' => $this->event_id,
            'topic' => $this->topic,
            'event_time' => $this->time,
            'speaker' => $this->speaker,
        ];
    }
}
