<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['value', 'type_id', 'event_id'];

    public function type()
    {
        return $this->belongsTo('App\MediaType', 'type_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
