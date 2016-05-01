<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    protected $fillable = ['uuid', 'data', 'user_id'];
}
