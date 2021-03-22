<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = ['salary_scale', 'basic_salary', 'allowance_coefficient'];
}
