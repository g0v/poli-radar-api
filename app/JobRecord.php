<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRecord extends Model
{
  protected $fillable = [
    'subtitle',
    'start',
    'end',
    'job_id',
    'job_position_id',
  ];

  public function job()
  {
    return $this->belongsTo('App\Job');
  }

  public function position()
  {
    return $this->belongsTo('App\JobPosition');
  }
}
