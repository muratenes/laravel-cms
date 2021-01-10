<?php

use App\Models\Ayar;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategorilerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategorilerTableName = 'kategoriler';
//        DB::table($kategorilerTableName)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Kategori::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = json_decode(file_get_contents(database_path('seeds/files/categories.json'), true),true);
        foreach ($categories as $category) {
            $parent = Kategori::create([
                'title' => $category['title'],
                'slug' => Str::slug($category['title'])
            ]);
            if (isset($category['children'])) {
                foreach ($category['children'] as $child){
                    $parent->sub_categories()->create(array_merge($child,[
                        'slug' => Str::slug("{$parent->title} {$child['title']}")
                    ]));
                }
            }

        }
    }
}
