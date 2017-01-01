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
        return $this->hasMany('App\Event');
    }

    public function member()
    {
        return $this->hasMany('App\Membership');
    }

}
