<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //to run this seeder php artisan db:seed --class=UserSeeder
        $admin = User::create(
            [
            'first_name' => 'Super', 
            'last_name' => 'Admin', 
            'email' => 'superadmin@admin.com',
            'username' => 'superadmin',
            'designation_id' => 1,
            'contact' => 1234567890,
            'password' => bcrypt('1234qwer'),
            ]
        );

        $admin->assignRole(1);

        $cashier = User::create(
            [
            'first_name' => 'Cashier', 
            'last_name' => 'Admin', 
            'email' => 'cashier@cashier.com',
            'username' => 'cashier',
            'designation_id' => 2,
            'contact' => 1234567890,
            'password' => bcrypt('jollitea2021'),
            ]
        );

        $cashier->assignRole(2);
    }
}
