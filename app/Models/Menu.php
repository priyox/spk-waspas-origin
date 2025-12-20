<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Menu extends Model
{
    protected $fillable = [
        'menu_name',
        'route',
        'icon',
        'parent_id',
        'order',
        'permission_name',
        'is_active',
    ];

    // ======================
    // RELASI MENU ↔ ROLE
    // ======================
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'menu_role',
            'menu_id',
            'role_id'
        );
    }

    // ======================
    // RELASI HIERARKI MENU
    // ======================
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
                    ->orderBy('order');
    }
}
