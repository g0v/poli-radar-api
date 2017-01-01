<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationClassification extends Model
{
  protected $fillable = ['name'];

  public function organizations()
  {
    return $this->hasMany('App\Organization', 'classification_id');
  }

}
