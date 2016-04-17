<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Politician extends Model
{
    protected $fillable = ['name', 'party_id'];

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    public function party()
    {
        return $this->belongsTo('App\Party');
    }

    public function categories()
    {
        return $this->belongsToMany('App\PoliticianCategory');
    }

}