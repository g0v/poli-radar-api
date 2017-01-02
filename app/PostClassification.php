<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PostClassification extends Model
{
  protected $fillable = ['name'];

  public function posts()
  {
    return $this->hasMany('App\Post');
  }

  public function event_category()
  {
    return $this->belongsTo('App\EventCategory');
  }

}
