<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\KategoriUrun;
use App\Models\Product\Urun;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UrunlerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker)
    {
//        DB::table("Urunler")->delete();
        if ('mysql' === config('database.default')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Urun::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else {
            Urun::truncate();
        }

        DB::delete('TRUNCATE TABLE kategori_urun;');
        for ($i = 0; $i < 4; $i++) {
            $product_name = $faker->sentence(random_int(2, 4));
            $priceTL = random_int(10, 130);
            $category = Kategori::whereNull('parent_category_id')->inRandomOrder()->first();

            $slug = \Illuminate\Support\Str::slug($product_name);
            $imageName = $slug . '.jpg';
            Storage::put('public/products/' . $imageName, file_get_contents(
                'https://source.unsplash.com/random/600x800?sig=incrementingIdentifie'
            ));

            $product = Urun::create([
                'title'              => $product_name,
                'slug'               => $slug,
                'desc'               => $faker->sentence(100),
                'tl_price'           => $priceTL, //$faker->randomFloat(2, 10, 100),
                'image'              => $imageName,
                'qty'                => random_int(0, 25),
                'usd_price'          => round($priceTL / 5),
                'eur_price'          => round($priceTL / 10),
                'parent_category_id' => $category->id,
                'sub_category_id'    => $category->sub_categories()->inRandomOrder()->first()->id,
            ]);

            KategoriUrun::create([
                'category_id' => $category->id,
                'product_id'  => $product->id,
            ]);
        }
    }
}
