<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'sub_menus';
    protected $primaryKey = 'sub_menu_id';
    protected $fillable = ['menu_id', 'nama_sub_menu', 'route', 'route_params', 'icon'];
    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }

    public function roleSubMenuAccesses()
    {
        return $this->hasMany(RoleSubMenuAccess::class, 'sub_menu_id', 'sub_menu_id');
    }
}
