<?php

namespace App\Models;

class Role extends BaseModel
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')->withTimestamps();
    }
}
