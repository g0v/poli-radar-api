<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded  = [
      'id',
      'created_at',
      'updated_at',
    ];

    protected $table = 'persons';

    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    public function memberships()
    {
        return $this->hasMany('App\Membership');
    }

}
