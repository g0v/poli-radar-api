<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['name'];

    public function members()
    {
        return $this->hasMany('App\Politician');
    }
}
