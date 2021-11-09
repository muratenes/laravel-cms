<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::truncate();
        Category::factory()
            ->count(100)
            ->create()
        ;

        foreach (Category::all() as $index => $category) {
            if (0 === $index % 5 && Category::count()) {
                $category->update([
                    'parent_category_id' => Category::inRandomOrder()
                        ->where(['categorizable_type' => $category->categorizable_type])
                        ->where('id', '!=', $category->id)
                        ->first()->id,
                ]);
            }
        }
    }
}
