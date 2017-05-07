<?php

namespace App\Permissions;

use App\{Role, Permission};

trait HasPermissions
{
    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(array_flatten($permissions));

        if ( is_null($permissions) ) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    public function withdrawPermissionTo(...$permissions)
    {
        $permissions = $this->getAllPermissions(array_flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    public function updatePermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

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

    /**
     * Check if user has authorization to specific permission
     *
     * @param  \App\Permission  $permission
     *
     * @return boolean
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) ||
               $this->hasPermission($permission);
    }

    /**
     * Check if permission through role
     *
     * @param  \App\Permission  $permission
     *
     * @return boolean
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ( $this->roles->contains($role) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check permission to user
     *
     * @param  \App\Permission  $permission
     *
     * @return boolean             [description]
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)
                                        ->count();
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
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
