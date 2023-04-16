<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'           => $this->faker->text(100),
            'sub_title'       => $this->faker->text(100),
            'sub_title_2'     => $this->faker->text(100),
            'link'            => $this->faker->url,
            'image'           => $this->faker->imageUrl,
            'active'          => 1,
            'lang'            => 1,
        ];
    }
}
