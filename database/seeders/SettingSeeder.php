<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //to run this seeder php artisan db:seed --class=SettingSeeder
        $settings = [
            ['attribute' => 'start_of_day', 'value' => '08:00:00'],
            ['attribute' => 'end_of_day', 'value' => '18:00:00'],
            ['attribute' => 'half_day', 'value' => '4'],
            ['attribute' => 'whole_day', 'value' => '8']
        ];
        foreach ($settings as $setting) {
            Setting::create([
                'attribute' => $setting['attribute'], 
                'value' => $setting['value'],
                'created_by' => 1,
            ]);
        }
    }
}
