<?php

use App\Models\Ayar;
use Illuminate\Database\Seeder;

class AyarlarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $config = [
            'title'       => 'Site Default Başlık',
            'desc'        => 'site default açıklama',
            'domain'      => 'http://127.0.0.1::8000',
            'logo'        => 'logo.png',
            'footer_logo' => 'footer_logo.png',
            'icon'        => 'icon.png',
            'keywords'    => 'kelime,ornek,default',
            'footer_text' => 'footer örnek yazı',
            'mail'        => 'ornek@mail.com',
            'adres'       => 'örnek adres bilgileri',
            'active'      => 1,
            'lang'        => config('admin.default_language'),
        ];

        foreach (Ayar::activeLanguages() as $language) {
            $newConfig = $config;
            $newConfig['lang'] = $language[0];
            $newConfig['cargo_price'] = random_int(1, 5) * 10;
            $newConfig['title'] = $language[1] . ' ' . $config['title'];
            $data = Ayar::updateOrCreate([
                'lang' => $language[0],
            ], $newConfig);
            Ayar::setCache($data, $language[0]);
        }
    }
}
