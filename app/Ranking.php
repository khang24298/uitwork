<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = [
        'user_id', 'rank_by_task_criteria_score', 'rank_by_user_criteria_score', 'total_rank'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
