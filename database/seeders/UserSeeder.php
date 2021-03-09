<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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
                'id'         => 1,
                'first_name' => 'User',
                'last_name'  => null,
                'email'      => 'user@example.com',
            ],
        ];

        $now = now();
        $password = App::isProduction()
            ? '$2y$10$C.51oxcSnjtm57sBoh7rbewKKRf/YeomxjaKxihs4fvs/THuz9NTW'
            : '$2y$10$C.51oxcSnjtm57sBoh7rbewKKRf/YeomxjaKxihs4fvs/THuz9NTW'; // password

        foreach ($seeds as $seed) {
            $seed['email_verified_at'] = $now;
            $seed['password'] = $password;
            $seed['remember_token'] = Str::random(60);

            \App\Models\User::create($seed);
        }
    }
}
