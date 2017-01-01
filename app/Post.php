<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];

  public function member()
  {
    return $this->hasMany('App\Membership');
  }

  public function organization()
  {
    return $this->belongsTo('App\Organization');
  }

  public function classification()
  {
    return $this->belongsTo('App\PostClassification');
  }
}
