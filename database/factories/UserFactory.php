<?php

namespace Database\Factories;

use App\Models\Auth\Role;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => $this->faker->name,
            'surname'   => $this->faker->lastName,
            'email'     => $this->faker->email,
            'password'  => \Hash::make(config('admin.password')),
            'is_active' => 1,
            'locale'    => 'tr',
            'role_id'   => Role::inRandomOrder()->first()->id,
        ];
    }
}
