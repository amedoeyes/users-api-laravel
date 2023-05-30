<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $clientRole = Role::create(['name' => 'client']);

        $viewRolesPermission = Permission::create(['name' => 'view_roles']);
        $createRolesPermission = Permission::create(['name' => 'create_roles']);
        $updateRolesPermission = Permission::create(['name' => 'update_roles']);
        $deleteRolesPermission = Permission::create(['name' => 'delete_roles']);

        $viewPermissionsPermission = Permission::create(['name' => 'view_permissions']);
        $createPermissionsPermission = Permission::create(['name' => 'create_permissions']);
        $updatePermissionsPermission = Permission::create(['name' => 'update_permissions']);
        $deletePermissionsPermission = Permission::create(['name' => 'delete_permissions']);

        $viewUsersPermission = Permission::create(['name' => 'view_users']);
        $createUsersPermission = Permission::create(['name' => 'create_users']);
        $updateUsersPermission = Permission::create(['name' => 'update_users']);
        $updateUsersRolesPermission = Permission::create(['name' => 'update_users_roles']);
        $deleteUsersPermission = Permission::create(['name' => 'delete_users']);

        $adminRole->permissions()->attach([
            $viewRolesPermission->id,
            $createRolesPermission->id,
            $updateRolesPermission->id,
            $deleteRolesPermission->id,

            $viewPermissionsPermission->id,
            $createPermissionsPermission->id,
            $updatePermissionsPermission->id,
            $deletePermissionsPermission->id,

            $viewUsersPermission->id,
            $createUsersPermission->id,
            $updateUsersPermission->id,
            $updateUsersRolesPermission->id,
            $deleteUsersPermission->id
        ]);
    }
}
