<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = [
        'user_id', 'score_by_task_criteria', 'score_by_personnel_criteria', 'total_score',
        'rank_by_task_criteria_score', 'rank_by_personnel_criteria_score', 'total_rank'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
