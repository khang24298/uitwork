<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factory;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Shanmuga\LaravelEntrust\Models\EntrustPermission;

class Permission extends EntrustPermission
{
    // use Factory;

    protected $table = 'permissions';

    protected $fillable = ['name', 'display_name', 'description', 'group_permission_id'];

    public function groups()
    {
        return $this->belongsTo(GroupPermission::class, 'group_permission_id', 'id');
    }
}
