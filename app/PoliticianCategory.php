<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PoliticianCategory extends Model
{
    protected $fillable = ['name', 'event_category_id'];

  public function politicians()
  {
    return $this->belongsToMany('App\Politician');
  }

  public function eventCategory()
  {
    return $this->belongsTo('App\EventCategory');
  }

}
