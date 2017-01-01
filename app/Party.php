<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
  protected $fillable = [
    'name',
    'start',
    'end',
    'image',
    'color',
  ];

  public function jobs()
  {
    return $this->hasMany('App\Job');
  }
}
