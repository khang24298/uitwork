<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id','assignee_id', 'task_name', 'description', 'project_id',
        'start_date', 'end_date', 'status_id', 'qa_id', 'priority'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
