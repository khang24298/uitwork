<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Psy\Command\HistoryCommand;

class WorkProcess extends Model
{
    protected $fillable = [
        'process_name', 'process_id', 'status_id', 'next_status_id', 'prev_status_id', 'department_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
