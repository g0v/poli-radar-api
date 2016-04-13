<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	use \Conner\Tagging\Taggable;

    protected $guarded = ['id'];

    public function guy()
    {
        return $this->belongsTo('App\Guy');
    }
}
