<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Asset permissions
            'view assets',
            'create assets',
            'edit assets',
            'delete assets',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Borrowing permissions
            'view borrowings',
            'approve borrowings',
            'reject borrowings',
            'manage borrowings',
            
            // Report damage permissions
            'view report damages',
            'create report damages',
            'edit report damages',
            'delete report damages',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to superadmin (all permissions)
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign permissions to admin
        $adminRole->givePermissionTo([
            'view assets',
            'create assets',
            'edit assets',
            'view categories',
            'create categories',
            'edit categories',
            'view borrowings',
            'approve borrowings',
            'reject borrowings',
            'manage borrowings',
            'view report damages',
            'create report damages',
            'edit report damages',
        ]);

        // Assign permissions to user
        $userRole->givePermissionTo([
            'view assets',
            'view categories',
            'create report damages',
        ]);

    }
}