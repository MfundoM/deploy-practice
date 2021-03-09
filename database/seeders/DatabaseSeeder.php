<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Options
        $this->call(SettingSeeder::class);

        // Users
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);

        // Content
        //
    }
}
