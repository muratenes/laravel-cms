<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product\Urun;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
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
            'title'              => $title = $this->faker->word,
            'slug'               => Str::slug($title),
            'categorizable_type' => $this->faker->randomElement($this->categoryTypes()),
            'is_active'          => 1,
        ];
    }

    private function categoryTypes()
    {
        return [
            Banner::class,
            Blog::class,
            Urun::class,
        ];
    }
}
