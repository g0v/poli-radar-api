<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'address',
        'lat',
        'lng',
        'region_id'
    ];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function categories()
    {
        return $this->belongsToMany('App\LocationCategory');
    }
}
