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

  public function eventCategory()
  {
    return $this->belongsTo('App\EventCategory');
  }

}
