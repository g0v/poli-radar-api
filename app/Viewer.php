<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    protected $fillable = ['hash', 'data', 'user_id'];
}
