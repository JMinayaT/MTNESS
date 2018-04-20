<?php

namespace Modules\Auth\Policies;


use Modules\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can browse the role.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function browse(User $user)
    {
        return $user->hasPermissionTo('browse_roles');
    }

    /**
     * Determine whether the user can read the user.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function read(User $user)
    {
        return $user->hasPermissionTo('read_roles');
    }
    /**
     * Determine whether the user can store the user.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function store(User $user)
    {
        return $user->hasPermissionTo('add_roles');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function update(User $user)
    {
        return $user->hasPermissionTo('edit_roles');
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete_roles');
    }
}