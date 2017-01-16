<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $fillable = ['name', 'slug'];

    public function medias()
    {
        return $this->hasMany('App\Media', 'type_id');
    }
}
