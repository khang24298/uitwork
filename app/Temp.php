<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $fillable = ['name', 'description'];

    public $table = "temp";
}
