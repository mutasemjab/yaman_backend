<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

        $permissions_admin = [


            'role-table',
            'role-add',
            'role-edit',
            'role-delete',

            'employee-table',
            'employee-add',
            'employee-edit',
            'employee-delete',

            'customer-table',
            'customer-add',
            'customer-edit',
            'customer-delete',

            'category-table',
            'category-add',
            'category-edit',
            'category-delete',

            'unit-table',
            'unit-add',
            'unit-edit',
            'unit-delete',

            'order-table',
            'order-add',
            'order-edit',
            'order-delete',

            'offer-table',
            'offer-add',
            'offer-edit',
            'offer-delete',


            'delivery-table',
            'delivery-add',
            'delivery-edit',
            'delivery-delete',

            'notification-table',
            'notification-add',
            'notification-edit',
            'notification-delete',

            'coupon-table',
            'coupon-add',
            'coupon-edit',
            'coupon-delete',

            'banner-table',
            'banner-add',
            'banner-edit',
            'banner-delete',

            'setting-table',
            'setting-add',
            'setting-edit',
            'setting-delete',
            
            'branch-table',
            'branch-add',
            'branch-edit',
            'branch-delete',

        ];

         foreach ($permissions_admin as $permission_ad) {
            Permission::create(['name' => $permission_ad, 'guard_name' => 'admin']);
        }
    }
}
