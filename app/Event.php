<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo('App\Type');
    }
}
