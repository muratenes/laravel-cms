<?php

namespace App\Utils\Concerns\Admin;

use App\Models\Product\Urun;
use App\Models\Product\UrunDescription;
use App\Models\Product\UrunImage;
use Illuminate\Http\Request;

trait ProductConcern
{
    /**
     * ürün variant bilgilerini günceller.
     *
     * @param $entry
     * @param $request
     *
     * @return false|void
     */
    protected function saveProductVariants($entry, $request)
    {
        if (! $entry || ! $request->has('variants')) {
            return false;
        }
        foreach ($request->all()['variants'] as $variantItem) {
            $subAttributesIds = array_column($variantItem['attributes'], 'sub_attribute');
            $variantData = [
                'id'       => (int) $variantItem['id'],
                'qty'      => (int) $variantItem['qty'],
                'price'    => (float) $variantItem['price'],
                'currency' => (int) $variantItem['currency'],
            ];
            $this->model->saveProductVariants($entry, $variantData, $subAttributesIds);
        }
    }

    /**
     *  ürün galeri yükler.
     *
     * @param Request $request
     * @param Urun    $entry
     */
    protected function uploadProductMainImageAndGallery(Request $request, Urun $entry)
    {
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $entry->title, 'public/products', $entry->image, Urun::MODULE_NAME);
            $entry->update(['image' => $imagePath]);
        }
        if ($request->hasFile('imageGallery')) {
            foreach (request()->file('imageGallery') as $index => $file) {
                if ($index < 10) {
                    $uploadPath = $this->uploadImage($file, $entry->title, 'public/product-gallery/', null, UrunImage::MODULE_NAME);
                    UrunImage::create(['product' => $entry->id, 'image' => $uploadPath]);
                } else {
                    session()->flash('message', 'ürüne ait en fazla 10 adet resim yükleyebilirsiniz');
                    session()->flash('message_type', 'danger');

                    break;
                }
            }
        }
    }

    /**
     *  formdan gönderilen attributeları geitir.
     *
     * @param $request
     *
     * @return array
     */
    protected function getProductAttributeDetailFromRequest($request)
    {
        $productSelectedAttributesIdAnSubAttributeIdList = [];
        $index = 0;
        do {
            if ($request->has("attribute{$index}")) {
                array_push($productSelectedAttributesIdAnSubAttributeIdList, [$request->get("attribute{$index}"), $request->get("subAttributes{$index}")]);
            }
            $index++;
        } while ($index < 10);

        return $productSelectedAttributesIdAnSubAttributeIdList;
    }

    /**
     * diğer diller için ürün bilgilerini kaydeder.
     *
     * @param Request $request
     * @param Urun    $product
     */
    protected function syncProductForOtherLanguages(Request $request, Urun $product)
    {
        foreach ($this->otherActiveLanguages() as $language) {
            if ($request->has('title_' . $language[0])) {
                $productTitle = $request->get("title_{$language[0]}");
                $productSpot = $request->get("spot_{$language[0]}");
                $productDesc = $request->get("desc_{$language[0]}");
                $productTags = $request->get("tags_{$language[0]}");
                $productCargoPrice = $request->get("cargo_price_{$language[0]}");
                $productProperties = $request->get("{$language[0]}_properties");

                UrunDescription::updateOrCreate(
                    ['lang' => $language[0], 'product_id' => $product->id],
                    [
                        'title'       => $productTitle,
                        'spot'        => $productSpot,
                        'desc'        => $productDesc,
                        'tags'        => $productTags,
                        'properties'  => $productProperties,
                        'cargo_price' => $productCargoPrice,
                    ]
                );
            } else {
                UrunDescription::create([
                    'lang'       => $language[0],
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
