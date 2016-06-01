<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PoliticianCategory extends Model
{

  public function politicians()
  {
    return $this->belongsToMany('App\Politician');
  }

  public function eventCategory()
  {
    return $this->belongsTo('App\EventCategory');
  }

}
