<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_registrations';

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

     /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public function ticket(){
        $this->belongsTo('App\Ticket','ticket_id');
    }
}
