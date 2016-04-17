<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = ['id'];

    public function politicians()
    {
        return $this->belongsToMany('App\Politician');
    }

    public function added_by()
    {
        return $this->belongsTo('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\EventCategory');
    }
}
