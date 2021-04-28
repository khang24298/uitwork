<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    // protected $guarded = [];
    protected $fillable = ['title', 'content', 'type_id', 'task_id', 'project_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function type()
    {
        return $this->belongsTo(ReportType::class, 'type_id');
    }
}
