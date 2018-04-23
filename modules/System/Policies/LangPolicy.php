<?php
namespace Modules\System\Policies;

use Modules\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LangPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can browse the lang.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function browse(User $user)
    {
        return $user->hasPermissionTo('browse_lang');
    }

    /**
     * Determine whether the user can read the lang.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function read(User $user)
    {
        return $user->hasPermissionTo('read_lang');
    }

    /**
     * Determine whether the user can read lang default the lang.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function readDefault(User $user)
    {
        return $user->hasPermissionTo('default_lang');
    }

    /**
     * Determine whether the user can read lang user the lang.
     *
     * @param  \Modules\Users\Models\User  $user
     * @return mixed
    */
    public function readUser(User $user)
    {
        return $user->hasPermissionTo('user_lang');
    }
}
