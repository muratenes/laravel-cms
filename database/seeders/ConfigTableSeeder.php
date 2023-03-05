<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $config = [
            'title'         => config('app.name'),
            'desc'          => 'site default açıklama',
            'domain'        => 'http://127.0.0.1::8000',
            'logo'          => 'logo.png',
            'footer_logo'   => 'footer_logo.png',
            'icon'          => 'icon.png',
            'keywords'      => 'kelime,ornek,default',
            'footer_text'   => "Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler.",
            'email'         => 'ornek@mail.com',
            'address'       => 'Churchill-laan 266/III
1078 GA AMSTERDAM
Netherlands',
            'active'        => 1,
            'lang'          => config('admin.default_language'),
        ];

        foreach (Config::activeLanguages() as $language) {
            $newConfig = $config;
            $newConfig['lang'] = $language[0];
            $newConfig['cargo_price'] = random_int(1, 5) * 10;
            $newConfig['title'] = $language[1] . ' ' . $config['title'];
            $data = Config::updateOrCreate([
                'lang' => $language[0],
            ], $newConfig);
            Config::setCache($data, $language[0]);
        }
    }
}
