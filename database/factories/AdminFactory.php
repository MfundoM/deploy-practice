<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string $model
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'super_admin'    => $this->faker->boolean,
            'first_name'     => $this->faker->firstName,
            'last_name'      => $this->faker->lastName,
            'email'          => $this->faker->unique()->safeEmail,
            'role'           => null,
            'avatar'         => '/images/avatars/placeholder.png',
            'password'       => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'api_token'      => Str::random(60),
            'remember_token' => Str::random(60),
        ];
    }
}
