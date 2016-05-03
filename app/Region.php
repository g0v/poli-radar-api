<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'postcode', 'city_id'];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
