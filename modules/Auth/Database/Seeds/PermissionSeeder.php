<?php
namespace Modules\Auth\Database\Seeds;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PERMISSION
        app()['cache']->forget('spatie.permission.cache');
        $this->command->warn("spatie permission, starting clean cache.");
        
        // Seed the default permissions
        $permissions = Permission::defaultPermissions();
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $this->command->info('Default Permissions added.');

        // ROLES
        $this->command->warn('creating roles.');
        $role = Role::create(['name' => 'super_admin']);

        // assign all permissions to super_admin role
        $role->permissions()->sync(Permission::all());
        $this->command->info('super_admin will have full rights');

        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('browse_admin');

        $this->command->info('Default Roles added.');
    }
}