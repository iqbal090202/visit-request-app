<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
        'visit-request-list',
        'visit-request-create',
        'visit-request-edit',
        'visit-request-acceptance',
        'visit-request-delete',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $user = User::create([
            'name' => 'SUPER ADMIN',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('superadmin')
        ]);

        $role = Role::create(['name' => 'superadmin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $role2 = Role::create(['name' => 'admin']);

        $role2->givePermissionTo('visit-request-list');
        $role2->givePermissionTo('visit-request-create');
        $role2->givePermissionTo('visit-request-edit');
        $role2->givePermissionTo('visit-request-acceptance');
        $role2->givePermissionTo('visit-request-delete');
    }
}
