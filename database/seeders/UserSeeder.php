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
        $user = User::create(
            [
            'first_name' => 'Super', 
            'last_name' => 'Admin', 
            'email' => 'superadmin@admin.com',
            'username' => 'superadmin',
            'designation_id' => 1,
            'contact' => 1234567890,
            'password' => bcrypt('qweqweqwe'),
            ]
        );

        $user->assignRole(1);
    }
}
