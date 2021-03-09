<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [
                'id'          => 1,
                'first_name'  => 'Admin',
                'last_name'   => 'User',
                'email'       => 'admin@example.com',
                'role'        => 'Developer',
            ],
        ];

        $password = App::isProduction()
            ? '$2y$10$C.51oxcSnjtm57sBoh7rbewKKRf/YeomxjaKxihs4fvs/THuz9NTW'
            : '$2y$10$C.51oxcSnjtm57sBoh7rbewKKRf/YeomxjaKxihs4fvs/THuz9NTW'; // password

        foreach ($seeds as $seed) {
            $seed['super_admin'] = 1;
            $seed['password'] = $password;

            \App\Models\Admin::create($seed);
        }
    }
}
