<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];

  public function organization()
  {
    return $this->belongsTo('App\Organization');
  }

  public function person()
  {
    return $this->belongsTo('App\Person');
  }

  public function post()
  {
    return $this->belongsTo('App\Post');
  }
}
