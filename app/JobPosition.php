<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
  protected $fillable = [
    'name',
    'description',
  ];

  public function jobs()
  {
      return $this->belongsToMany('App\Job');
  }
}
