<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    // protected $guarded = [];

    protected $fillable = ['user_id', 'task_id', 'max_score', 'criteria_name', 'criteria_type_id', 'description'];

    public $table = "criteria";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function type()
    {
        return $this->belongsTo(CriteriaType::class, 'criteria_type_id');
    }
}
