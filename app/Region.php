<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'postal_code', 'city_id'];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function events()
    {
        return $this->morphMany('App\Event', 'location');
    }
}
