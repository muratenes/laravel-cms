<?php

namespace App\Utils\Concerns\Admin;

use App\Models\Product\Product;
use App\Models\Product\ProductImage;
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
     * @param Product $entry
     */
    protected function uploadProductMainImageAndGallery(Request $request, Product $entry)
    {
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'), $entry->title, 'public/products', $entry->image, Product::MODULE_NAME);
            $entry->update(['image' => $imagePath]);
        }
        if ($request->hasFile('imageGallery')) {
            foreach (request()->file('imageGallery') as $index => $file) {
                if ($index < 10) {
                    $uploadPath = $this->uploadImage($file, $entry->title, 'public/product-gallery/', null, ProductImage::MODULE_NAME);
                    ProductImage::create(['product' => $entry->id, 'image' => $uploadPath]);
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
                $productSelectedAttributesIdAnSubAttributeIdList[] = [$request->get("attribute{$index}"), $request->get("subAttributes{$index}")];
            }
            $index++;
        } while ($index < 10);

        return $productSelectedAttributesIdAnSubAttributeIdList;
    }
}
