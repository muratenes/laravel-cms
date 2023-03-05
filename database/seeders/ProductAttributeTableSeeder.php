<?php

namespace Database\Seeders;

use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductDetail;
use App\Models\Product\ProductSubDetail;
use Illuminate\Database\Seeder;

class ProductAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $attributes = json_decode(file_get_contents(database_path('seeders/files/product-attributes.json'), true), true);
        foreach ($attributes as $attribute) {
            $parent = ProductAttribute::updateOrCreate(
                [
                    'title' => $attribute['title'],
                ]
            );
            if (isset($attribute['children'])) {
                foreach ($attribute['children'] as $child) {
                    $parent->subAttributes()->updateOrCreate([
                        'title' => $child['title'],
                    ], []);
                }
            }
        }
        foreach (Product::all() as $product) {
            $attributes = ProductAttribute::inRandomOrder()->take(5)->get();
            foreach ($attributes as $attribute) {
                $productDetail = ProductDetail::create(['product' => $product->id, 'parent_attribute' => $attribute->id]);

                ProductSubDetail::create(['parent_detail' => $productDetail->id, 'sub_attribute' => $attribute->subAttributes()->inRandomOrder()->first()->id]);
            }
        }
    }
}
