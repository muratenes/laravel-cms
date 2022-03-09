<?php

namespace App\Utils\Concerns\Admin;

use App\Models\MultiLanguage;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunSubAttribute;
use Illuminate\Http\Request;

trait ProductAttributeConcern
{
    /**
     * ürün sub attribute diğer dillerdeki karşılıklarını oluşturur veya günceller.
     *
     * @param Request       $request
     * @param UrunAttribute $attribute
     */
    public function syncProductSubAttributeOtherLanguages(Request $request, UrunAttribute $attribute)
    {
        foreach (range(0, 10) as $index) {
            $defaultLanguageSubAttributeTitle = $request->get("main_product_sub_attribute_title_{$index}");
            $defaultLanguageSubAttributeId = $request->get("main_product_sub_attribute_id_{$index}");
            if (! $defaultLanguageSubAttributeTitle) {
                break;
            }

            // sub attribute ana dil
            if (0 !== $defaultLanguageSubAttributeId) {
                UrunSubAttribute::find($defaultLanguageSubAttributeId)->update(['title' => $defaultLanguageSubAttributeTitle]);
            } else {
                $defaultLanguageSubAttributeId = $attribute->subAttributes()
                    ->create(['title' => $defaultLanguageSubAttributeTitle])->id;
            }
            // sub attribute diğer diller
            $subAttributeDescriptionIndex = 0;
            foreach ($this->otherActiveLanguages() as $language) {
                if ($request->has("product_sub_attribute_id_{$index}_{$subAttributeDescriptionIndex}")) {
                    $subAttributeTitle = $request->get("product_sub_attribute_title_{$index}_{$subAttributeDescriptionIndex}");
                    $subAttributeDescriptionLang = $request->get("product_sub_attribute_lang_{$index}_{$subAttributeDescriptionIndex}");
                    MultiLanguage::updateOrCreate(
                        ['lang' => $subAttributeDescriptionLang, 'languageable_id' => $defaultLanguageSubAttributeId, 'languageable_type' => UrunSubAttribute::class],
                        ['data' => ['title' => $subAttributeTitle]]
                    );
                } else {
                    MultiLanguage::create([
                        'lang'              => $language[0],
                        'languageable_id'   => $defaultLanguageSubAttributeId,
                        'languageable_type' => UrunSubAttribute::class,
                        'data'              => $this->getInitialDataColumnValue(new UrunSubAttribute()),
                    ]);
                }
                $subAttributeDescriptionIndex++;
            }
        }
//        dd('dur');
    }
}
