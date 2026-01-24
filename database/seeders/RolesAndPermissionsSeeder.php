<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cache permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar Permission berdasarkan Route di web.php
        $permissions = [
            // Dashboard & Profile
            'dashboard.view',
            'profile.manage',

            // Brand Management
            'brand.manage',
            'all.brand',
            'brand.create',
            'brand.edit',
            'brand.delete',

            // Warehouse Management
            'warehouse.menu',
            'All.warehouse',
            'warehouse.create',
            'warehouse.edit',
            'warehouse.delete',

            // Supplier Management
            'supplier.menu',
            'All.supplier',
            'supplier.create',
            'supplier.edit',
            'supplier.delete',

            // Customer Management
            'customer.menu',
            'All.customer',
            'customer.create',
            'customer.edit',
            'customer.delete',

            // Product & Category Management
            'product.menu',
            'All.product',
            'category.all', // Akses menu kategori
            'product.create',
            'product.edit',
            'product.delete',

            // Purchase Management
            'purchase.menu',
            'All.purchase',
            'purchase.create',
            'purchase.return',
            'purchase.delete',

            // Sale Management
            'Sale.menu',
            'All.sale',
            'sale.create',
            'sale.return',
            'sale.delete',

            // Due Management
            'due.menu',
            'All.due',

            // Transfer Management
            'transfer.menu',
            'All.transfer',
            'transfer.create',
            'transfer.edit',
            'transfer.delete',

            // Report Management
            'report.menu',
            'All.report',

            // Role & Permission (Super Admin)
            'role.permission.manage',
            'admin.user.manage',

            //Units
            'unit.all',
            'unit.store',
            'unit.update',
            'unit.delete',
        ];

        // Buat semua permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 1. Role: Super Admin (Memiliki semua akses)
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // 2. Role: Admin (Akses operasional tanpa Role Management)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'dashboard.view',
            'profile.manage',
            'brand.manage', 'all.brand',
            'warehouse.menu', 'All.warehouse',
            'supplier.menu', 'All.supplier',
            'customer.menu', 'All.customer',
            'product.menu', 'All.product', 'category.all',
            'purchase.menu', 'All.purchase',
            'Sale.menu', 'All.sale',
            'due.menu', 'All.due',
            'transfer.menu', 'All.transfer',
            'unit.menu', 'All.unit',
            'report.menu', 'All.report',
        ]);

        // 3. Role: Staff (Hanya View dan Create Transaksi)
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'dashboard.view',
            'All.product',
            'All.purchase', 'purchase.create',
            'All.sale', 'sale.create',
            'All.customer',
        ]);
    }
}