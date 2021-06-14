<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factory;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Shanmuga\LaravelEntrust\Models\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permissions';

    protected $fillable = ['name', 'display_name', 'description', 'group_permission_id'];

    public function group()
    {
        return $this->belongsTo(GroupPermission::class, 'group_permission_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
