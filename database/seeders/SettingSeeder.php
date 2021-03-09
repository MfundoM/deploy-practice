<?php

namespace Database\Seeders;

use App\Helpers\Settings;
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
        $seeds = [
//            [
//                'type'  => Settings::DATE,
//                'key'   => 'example_key',
//                'value' => now()->toDateTimeString(),
//            ],
        ];

        foreach ($seeds as $seed) {
            \App\Models\Setting::create($seed);
        }
    }
}
