<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
  protected $fillable = [
    'start',
    'end',
    'politician_id',
    'politician_category_id',
    'party_id',
  ];

  public function party()
  {
    return $this->belongsTo('App\Party');
  }

  public function politician()
  {
    return $this->belongsTo('App\Politician');
  }

  public function category()
  {
    return $this->belongsTo('App\PoliticianCategory', 'politician_category_id');
  }

  public function records()
  {
      return $this->hasMany('App\JobRecord');
  }
}
