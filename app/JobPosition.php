<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
  protected $fillable = [
    'title',
    'description',
  ];

  public function records()
  {
    return $this->hasMany('App\JobRecord');
  }
}
