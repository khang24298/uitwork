<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefusedTask extends Model
{
    protected $fillable = [
        'task_id', 'user_id', 'project_id', 'content'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
