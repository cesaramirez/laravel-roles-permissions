<?php

namespace App\Permissions;
use App\{Role, Permission};

trait HasPermissions
{
    /**
    * Check if user has role
    *
    * @param  array  $roles
    * @return boolean
    */
    public function hasRole(...$roles)
    {
      foreach ($roles as $role) {
        if ( $this->roles->contains('name', $role) ) {
          return true;
        }
      }

      return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission);
    }


    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)
                                        ->count();
    }

    /**
     * Get roles related with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Get permissions related with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }
}
