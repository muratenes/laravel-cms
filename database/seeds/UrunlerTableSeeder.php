<?php

use App\Models\Ayar;
use App\Models\Kategori;
use App\Models\KategoriUrun;
use App\Models\Product\Urun;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UrunlerTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
//        DB::table("Urunler")->delete();
        if (config('database.default') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Urun::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else {
            Urun::truncate();
        }

        DB::delete("TRUNCATE TABLE kategori_urun;");
        for ($i = 0; $i < 40; $i++) {
            $product_name = $faker->sentence(random_int(2, 4));
            $priceTL = random_int(10, 130);
            $category = Kategori::whereNull('parent_category_id')->inRandomOrder()->first();

            $slug = \Illuminate\Support\Str::slug($product_name);
            $imageName = $slug . '.jpg';
            Storage::put('public/products/' . $imageName, file_get_contents(
                "https://source.unsplash.com/random/600x800?sig=incrementingIdentifie"
            ));

            $product = Urun::create([
                'title' => $product_name,
                'slug' => $slug,
                'desc' => $faker->sentence(100),
                'tl_price' => $priceTL, //$faker->randomFloat(2, 10, 100),
                'image' => $imageName,
                'qty' => random_int(0, 25),
                'usd_price' => round($priceTL / 5),
                'eur_price' => round($priceTL / 10),
                'parent_category_id' => $category->id,
                'sub_category_id' => $category->sub_categories()->inRandomOrder()->first()->id
            ]);

            KategoriUrun::create([
                'category_id' => $category->id,
                'product_id' => $product->id
            ]);

//            // ingilizce ürün
//            $urun->title = '|EN|'.$urun->title;
//            $urun->slug = Str::slug($urun->title);
//            $urun->lang = Ayar::LANG_EN;
//            $urun->currency = Ayar::getLanguageCurrencyByLang($urun->lang);
//            $urun->main_product_id = $urun->id;
//            unset($urun->id);
//            $urunEN = Urun::create($urun->toArray());
//            $category_id = Kategori::where(['main_category_id' => $category_id, 'lang' => $urun->lang])->first()->id;
//            DB::insert("insert into kategori_urun (category_id, product_id) values ($category_id,$urunEN->id)");

        }
    }
}
