<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = ['name'];

    public function regions()
    {
        return $this->hasMany('App\Region');
    }

    public function events()
    {
        return $this->morphMany('App\Event', 'place');
    }
}
