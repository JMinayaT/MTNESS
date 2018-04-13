<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as ModelPermission;


class Permission extends ModelPermission
{
    public static function defaultPermissions()
    {
        return [           
            'browse_admin',
            'browse_settings',

            'browse_roles',
            'read_roles',
            'edit_roles',
            'add_roles',
            'delete_roles',

            'browse_users',
            'read_users',
            'edit_users',
            'add_users',
            'delete_users',

            'browse_lang',
            'read_lang',
            'default_lang',
            'user_lang',
        ];
    }
}
