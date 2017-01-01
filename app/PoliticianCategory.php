<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PoliticianCategory extends Model
{
    protected $fillable = ['name', 'event_category_id'];

  public function jobs()
  {
    return $this->hasMany('App\Job');
  }

  public function eventCategory()
  {
    return $this->belongsTo('App\EventCategory');
  }

}
