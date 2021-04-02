<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['position_name', 'description', 'salary_id'];

    public function salary()
    {
        return $this->belongsTo(Salary::class, 'salary_id');
    }
}
