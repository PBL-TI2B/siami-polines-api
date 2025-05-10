<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleSubMenuAccess extends Model
{
    protected $table = 'role_sub_menu_access';
    protected $primaryKey = 'id';
    protected $fillable = ['role_id', 'sub_menu_id'];
    public $timestamps = true;

    /**
     * Relasi: RoleSubMenuAccess milik Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Relasi: RoleSubMenuAccess milik SubMenu
     */
    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id', 'sub_menu_id');
    }
}
