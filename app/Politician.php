<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Politician extends Model
{
    protected $fillable = ['name'];

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    public function categories()
    {
        return $this->belongsToMany('App\PoliticianCategory');
    }

    public function traits()
    {
        return $this->belongsToMany('App\PoliticianTrait');
    }

}