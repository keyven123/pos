<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            ['attribute' => 'license', 'value' => null],
            ['attribute' => 'trial', 'value' => 1],
            ['attribute' => 'trial_end', 'value' => now()->addMonth(1)->format('F d, Y')],
            ['attribute' => 'start_of_day', 'value' => '08:00:00'],
            ['attribute' => 'end_of_day', 'value' => '18:00:00'],
            ['attribute' => 'half_day', 'value' => '4'],
            ['attribute' => 'whole_day', 'value' => '8'],
            ['attribute' => 'logo', 'value' => '/images/logo/logo.png'],
            ['attribute' => 'banner', 'value' => '/images/logo/banner.png'],
            ['attribute' => 'app_name', 'value' => 'Point of sale']
        ];
        foreach ($settings as $setting) {
            $exist = Setting::where('attribute', $setting['attribute'])->first();
            if  ($exist) {
                continue;
            }
            Setting::create([
                'attribute' => $setting['attribute'],
                'value' => $setting['value']
            ]);
        }
    }
}
