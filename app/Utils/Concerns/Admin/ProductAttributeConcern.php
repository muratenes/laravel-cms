<?php

namespace App\Utils\Concerns\Admin;

use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunSubAttribute;
use App\Models\Product\UrunSubAttributeDescription;
use Illuminate\Http\Request;

trait ProductAttributeConcern
{
    /**
     * ürün attribute diğer dillerdeki karşılıklarını oluşturur veya günceller.
     *
     * @param Request       $request
     * @param UrunAttribute $attribute
     */
    public function syncProductAttributeOtherLanguages(Request $request, UrunAttribute $attribute)
    {
        foreach ($this->otherActiveLanguages() as $language) {
            $title = $request->get('title_' . $language[0]);
            $attribute->descriptions()->updateOrCreate([
                'lang' => $language[0],
            ], [
                'title' => $title,
            ]);
        }
    }

    /**
     * ürün sub attribute diğer dillerdeki karşılıklarını oluşturur veya günceller.
     *
     * @param Request       $request
     * @param UrunAttribute $attribute
     */
    public function syncProductSubAttributeOtherLanguages(Request $request, UrunAttribute $attribute)
    {
        foreach (range(0, config('admin.product.max_sub_attribute_count')) as $index) {
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
                    UrunSubAttributeDescription::updateOrCreate(
                        ['lang' => $subAttributeDescriptionLang, 'sub_attribute_id' => $defaultLanguageSubAttributeId],
                        ['title' => $subAttributeTitle]
                    );
                } else {
                    UrunSubAttributeDescription::create(['lang' => $language[0], 'sub_attribute_id' => $defaultLanguageSubAttributeId]);
                }
                $subAttributeDescriptionIndex++;
            }
        }
    }
}
