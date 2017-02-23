<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    public function persons()
    {
        return $this->belongsToMany('App\Person');
    }

    public function added_by()
    {
        return $this->belongsTo('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\EventCategory');
    }

    public function place()
    {
        return $this->morphTo();
    }

    public function media()
    {
        return $this->hasOne('App\Media');
    }
}
