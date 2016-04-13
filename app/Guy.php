<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guy extends Model
{
    protected $fillable = ['name', 'color'];

    public function Activities()
    {
        return $this->hasMany('App\Activity');
    }

}