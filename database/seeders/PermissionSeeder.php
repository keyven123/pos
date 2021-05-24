<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //to run this seeder php artisan db:seed --class=PermissionSeeder
        $permission_name = [
            'product-view', 'product-create', 'product-edit', 'product-delete',
            'user-management-view', 'user-management-create', 'user-management-edit', 'user-management-delete',
            'dashboard-view', 'dashboard-create', 'dashboard-edit', 'dashboard-delete',
            'category-view', 'category-create', 'category-edit', 'category-delete',
            'inventory-view', 'inventory-create', 'inventory-edit', 'inventory-delete',
            'ingredient-view', 'ingredient-create', 'ingredient-edit', 'ingredient-delete',
            'role-view', 'role-create', 'role-edit', 'role-delete',
            'permission-view', 'permission-create', 'permission-edit', 'permission-delete',
            'order-view', 'order-create', 'order-edit', 'order-delete',
            'sales-view', 'sales-create', 'sales-edit', 'sales-delete',
            'product-component-view', 'product-component-create', 'product-component-edit', 'product-component-delete',
            'ordering-view', 'ordering-create', 'ordering-edit', 'ordering-delete',
        ];
        foreach ($permission_name as $name) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web'
            ]);
        }

        $role = Role::findOrFail(1);
        $role->syncPermissions($permission_name);
    }
}
