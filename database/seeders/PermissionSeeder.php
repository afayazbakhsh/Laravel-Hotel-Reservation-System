<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Permission
        $permissions = [

            'comment_create',
            'comment_show',
            'comment_delete',
            'comment_update',
        ];

        foreach ($permissions as $permission) {

            $permission = Permission::create(['name' => $permission]);
        }

        // Create user role
        $role = Role::create(['name' => 'user']);
        $userPermissions = [

            'comment_create',
            'comment_show',
        ];
        // give permission to role
        $role->syncPermissions($userPermissions);

        // Create super admin role
        $role = Role::create(['name' => 'super admin']);

        // Create requester role
        $role = Role::create(['name' => 'customer']);
    }
}
