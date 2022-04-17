<?php

namespace Database\Seeders;

use App\Models\Product\Urun;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunDetail;
use App\Models\Product\UrunSubDetail;
use Illuminate\Database\Seeder;

class UrunAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $attributes = json_decode(file_get_contents(database_path('seeders/files/product-attributes.json'), true), true);
        foreach ($attributes as $attribute) {
            $parent = UrunAttribute::updateOrCreate(
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
        foreach (Urun::all() as $product) {
            $attributes = UrunAttribute::inRandomOrder()->take(5)->get();
            foreach ($attributes as $attribute) {
                $productDetail = UrunDetail::create(['product' => $product->id, 'parent_attribute' => $attribute->id]);

                UrunSubDetail::create(['parent_detail' => $productDetail->id, 'sub_attribute' => $attribute->subAttributes()->inRandomOrder()->first()->id]);
            }
        }
    }
}
