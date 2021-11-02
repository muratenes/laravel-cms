<?php

namespace Database\Seeders;


use App\Models\Builder\Menu;
use App\Models\Builder\MenuDescription;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        MenuDescription::truncate();
        Menu::latest('id')->delete();
        $menus = [
            [
                'title'     => 'Anasayfa',
                'href'      => '/',
                'status'    => true,
                'order'     => 1,
                'languages' => [
                    [
                        'lang'  => \App\Models\Ayar::LANG_EN,
                        'title' => 'Home',
                        'href'  => '/',
                    ],
                ],
            ],
            [
                'title'     => 'Kurumsal',
                'href'      => '#',
                'status'    => true,
                'order'     => 2,
                'languages' => [
                    [
                        'lang'  => \App\Models\Ayar::LANG_EN,
                        'title' => 'Commercial',
                        'href'  => 'commercial',
                    ],
                ],
                'children' => [
                    [
                        'title'  => 'Hakkımızda',
                        'href'   => 'hakkimizda',
                        'status' => true,
                        'order'  => 1,
                    ],
                    [
                        'title'  => 'Vizyon',
                        'href'   => 'vizyon',
                        'status' => true,
                        'order'  => 1,
                    ],
                ],
            ],
        ];

        foreach ($menus as $menu) {
            $menuLanguages = $menu['languages'] ?? [];
            $children = $menu['children'] ?? [];
            unset($menu['languages'],$menu['children']);
            $menuItem = Menu::create($menu);
            foreach ($menuLanguages as $menuLanguage) {
                $menuLanguage['menu_id'] = $menuItem->id;
                MenuDescription::create($menuLanguage);
            }
            foreach ($children as $children) {
                $children['parent_id'] = $menuItem->id;
                Menu::create($children);
            }
        }
    }
}
