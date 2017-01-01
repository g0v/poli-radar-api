<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
  protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];

  public function parent()
  {
    return $this->belongsTo('App\Organization');
  }

  public function subs()
  {
    return $this->hasMany('App\Organization');
  }

  public function classification()
  {
    return $this->belongsTo('App\OrganizationClassification', 'classification_id');
  }

  public function posts()
  {
    return $this->hasMany('App\Post');
  }

  public function members()
  {
    return $this->hasMany('App\Membership');
  }
}
