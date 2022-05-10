<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineup extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lineups';

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

    public function event(){
        $this->belongsTo('App\Event','event_id');
    }

}
