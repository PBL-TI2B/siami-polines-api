<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['nama_role', 'prefix'];
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    public function roleMenuAccesses()
    {
        return $this->hasMany(RoleMenuAccess::class, 'role_id', 'role_id');
    }

    public function roleSubMenuAccesses()
    {
        return $this->hasMany(RoleSubMenuAccess::class, 'role_id', 'role_id');
    }
}
