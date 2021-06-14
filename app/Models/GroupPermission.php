<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factory;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Shanmuga\LaravelEntrust\Models\EntrustPermission;

class GroupPermission extends Model
{
    // use Factory;

    protected $table = 'group_permissions';

    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_permission_id', 'id');
    }
}
