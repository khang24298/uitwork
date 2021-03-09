<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // protected $guarded = [];

    protected $fillable = ['user_id', 'project_name', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
