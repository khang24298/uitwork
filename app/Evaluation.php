<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['task_id', 'user_id', 'score', 'note'];

    public $table = 'evaluation';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['created_at'];
    }
}
