<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'permissions' => ['manage_users', 'manage_books', 'manage_settings', 'view_reports', 'manage_rentals', 'manage_sales', 'manage_donations', 'manage_categories'],
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'permissions' => ['manage_books', 'manage_categories', 'view_reports'],
            ],
            [
                'name' => 'Billing',
                'slug' => 'billing',
                'permissions' => ['manage_rentals', 'manage_sales', 'view_reports'],
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'permissions' => ['browse_library', 'rent_books', 'buy_books'],
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(['slug' => $roleData['slug']], $roleData);
        }

        // Assign admin role to existing admins
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            User::where('role', 'admin')->update(['role_id' => $adminRole->id]);
        }

        // Assign user role to existing users
        $userRole = Role::where('slug', 'user')->first();
        if ($userRole) {
            User::where('role', '!=', 'admin')->update(['role_id' => $userRole->id]);
        }
    }
}
