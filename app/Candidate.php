<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name', 'color'];

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function eventsTransformed()
    {
    	return new ResourceCollection($user->posts, new PostTransformer);
    }
}