<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Politician extends Model
{
    protected $fillable = [
      'name',
      'born',
      'sex',
      'image',
    ];

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }

}
