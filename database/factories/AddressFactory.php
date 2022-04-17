<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\KullaniciAdres;
use App\Models\Region\Country;
use App\Models\Region\State;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->title,
            'name'        => $this->faker->name,
            'surname'     => $this->faker->lastName,
            'email'       => $this->faker->email,
            'phone'       => $this->faker->phoneNumber,
            'type'        => $this->faker->randomElement([KullaniciAdres::TYPE_DELIVERY, KullaniciAdres::TYPE_INVOICE]),
            'address'     => $this->faker->address,
            'country_id'  => Country::where('code', 'TR')->first()->id,
            'state_id'    => $state = State::inRandomOrder()->first()->id,
            'district_id' => $state->districts()->inRandomOrder()->first()->id,
            'user_id'     => User::inRandomOrder()->first()->id,
        ];
    }
}
