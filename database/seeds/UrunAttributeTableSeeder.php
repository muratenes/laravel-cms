<?php

use Illuminate\Database\Seeder;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunSubAttribute;
use App\Models\Product\UrunSubDetail;
use App\Models\Product\UrunDetail;

class UrunAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        UrunAttribute::truncate();
        UrunSubAttribute::truncate();
        UrunDetail::truncate();
        UrunSubDetail::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $urun = \App\Models\Product\Urun::orderByDesc('id')->first();

        $attribute1 = UrunAttribute::create(['title' => 'Renk']);
        $attribute2 = UrunAttribute::create(['title' => 'Beden']);
        $attribute3 = UrunAttribute::create(['title' => 'Hafıza']);

        $subAttribute1 = UrunSubAttribute::create(['parent_attribute' => $attribute1->id, 'title' => "Kırmızı"]);
        $subAttribute2 = UrunSubAttribute::create(['parent_attribute' => $attribute1->id, 'title' => "Mavi"]);
        $subAttribute3 = UrunSubAttribute::create(['parent_attribute' => $attribute1->id, 'title' => "Mor"]);


        $subAttribute4 = UrunSubAttribute::create(['parent_attribute' => $attribute2->id, 'title' => "X"]);
        $subAttribute5 = UrunSubAttribute::create(['parent_attribute' => $attribute2->id, 'title' => "M"]);
        $subAttribute6 = UrunSubAttribute::create(['parent_attribute' => $attribute2->id, 'title' => "L"]);


        $subAttribute7 = UrunSubAttribute::create(['parent_attribute' => $attribute3->id, 'title' => "32 GB"]);
        $subAttribute8 = UrunSubAttribute::create(['parent_attribute' => $attribute3->id, 'title' => "16 GB"]);
        $subAttribute9 = UrunSubAttribute::create(['parent_attribute' => $attribute3->id, 'title' => "8 GB"]);

        $urunDetail1 = UrunDetail::create(['product' => $urun->id, 'parent_attribute' => $attribute1->id]);
        $urunDetail2 = UrunDetail::create(['product' => $urun->id, 'parent_attribute' => $attribute2->id]);
        $urunDetail3 = UrunDetail::create(['product' => $urun->id, 'parent_attribute' => $attribute3->id]);

        UrunSubDetail::create(['parent_detail' => $urunDetail1->id, 'sub_attribute' => $subAttribute1->id]);
        UrunSubDetail::create(['parent_detail' => $urunDetail1->id, 'sub_attribute' => $subAttribute2->id]);

        UrunSubDetail::create(['parent_detail' => $urunDetail2->id, 'sub_attribute' => $subAttribute4->id]);
        UrunSubDetail::create(['parent_detail' => $urunDetail2->id, 'sub_attribute' => $subAttribute6->id]);

        UrunSubDetail::create(['parent_detail' => $urunDetail3->id, 'sub_attribute' => $subAttribute7->id]);
        UrunSubDetail::create(['parent_detail' => $urunDetail3->id, 'sub_attribute' => $subAttribute8->id]);
    }
}
