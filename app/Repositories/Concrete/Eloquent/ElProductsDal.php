<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Product\Product;
use App\Models\Product\ProductDetail;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductVariant;
use App\Models\Product\ProductVariantSubAttribute;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ElProductsDal extends BaseRepository implements ProductInterface
{
    use ResponseTrait;

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id, 'id', ['images', 'categories', 'favorites', 'commentsForDelete']);
        $product->detail()->delete();
        $product->categories()->detach();
        $product->favorites()->detach();
        $product->commentsForDelete()->delete();

        $deleteImages = [];
        $image_path_minify = getcwd() . config('constants.image_paths.product270x250_folder_path') . $product->image;
        $image_path = getcwd() . config('constants.image_paths.product_image_folder_path') . $product->image;
        array_push($deleteImages, $image_path_minify, $image_path);
        foreach ($product->images as $img) {
            $deleteImages[] = (getcwd() . config('constants.image_paths.product_gallery_folder_path') . $img->image);
        }
        foreach ($deleteImages as $di) {
            if (file_exists($di)) {
                \File::delete($di);
            }
        }
        $product->delete();

        return true;
    }

    public function getProductsByHasCategoryAndFilterText($category_id, $search_text, $company_id)
    {
        return $this->model->with(['categories'], [['title', 'like', "%{$search_text}%"]])->when(is_numeric($category_id), function ($query) use ($category_id) {
            $query->whereHas('categories', function ($q) use ($category_id) {
                $category = $this->categoryService->getById($category_id);
                $sub_categories = $category->sub_categories->pluck('id')->toArray();
                $sub_categories[] = $category->id;
                $q->whereIn('category_id', $sub_categories);
            });
        })->when(null !== $company_id, function ($query) use ($company_id) {
            $query->whereHas('info', function ($query) use ($company_id) {
                if (null !== $company_id) {
                    $query->where('company_id', $company_id);
                }
            });
        })->orderByDesc('id')->paginate();
    }

    public function updateWithCategory(array $productData, int $id, array $categories, array $selected_attributes_and_sub_attributes = null): Product
    {
        $entry = $this->find($id);
        if (! isset($productData['code']) && config('admin.product.auto_code')) {
            $productData['code'] = (int) ($entry->id . rand(1000, 999999));
        }
        $this->update($productData, $id);
        $entry->categories()->sync($categories);
        if (null !== $selected_attributes_and_sub_attributes) {
            foreach ($selected_attributes_and_sub_attributes as $attribute) {
                $productDetail = ProductDetail::firstOrCreate(['product' => $entry->id, 'parent_attribute' => $attribute[0]]);
                $productDetail->subDetailsForSync()->sync($attribute[1]);
            }
        }

        return $entry;
    }

    public function createWithCategory(array $productData, array $categories, array $selected_attributes_and_sub_attributes)
    {
        try {
            $code = $productData['code'] ?: (config('admin.product_auto_code') ? (int) (rand(1000, 999999)) : null);
            $entry = $this->create($productData);
            $productDetailData['code'] = $code;
            $entry->categories()->attach($categories);
            if (null !== $selected_attributes_and_sub_attributes) {
                foreach ($selected_attributes_and_sub_attributes as $attribute) {
                    $productDetail = ProductDetail::create(['product' => $entry->id, 'parent_attribute' => $attribute[0]]);
                    $productDetail->subDetailsForSync()->attach($attribute[1]);
                }
            }

            return $entry;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getSubAttributesByAttributeId(int $id)
    {
        return $this->productSubAttributeService->all([['parent_attribute', $id]])->get();
    }

    public function deleteProductDetail(int $detailId): bool
    {
        try {
            $productDetail = ProductDetail::with('product.variants')->findOrFail($detailId);

            $subAttributeIdList = $productDetail->attribute->subAttributes->pluck('id');
            $productVariantsIdList = Product::with('variants')->whereId($productDetail->product)->first()->variants()->pluck('id');
            ProductVariantSubAttribute::where(function ($query) use ($productVariantsIdList) {
                foreach ($productVariantsIdList as $variant_id) {
                    $query->orWhere('variant_id', $variant_id);
                }
            })->where(function ($query) use ($subAttributeIdList) {
                foreach ($subAttributeIdList as $subAttributeId) {
                    $query->orWhere('sub_attr_id', $subAttributeId);
                }
            })->delete();
            $productDetail->subDetailsForSync()->detach();
            $productDetail->delete();

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getProductDetailWithSubAttributes($productId): array
    {
        $product = $this->find($productId, 'id', ['detail.subDetails.parentSubAttribute']);
        foreach ($product->detail as $de) {
            $de['parent_title'] = $de->attribute->title;
        }

        return $product->toArray();
    }

    public function deleteProductVariant(int $variantId): void
    {
        $productVariant = ProductVariant::findOrFail($variantId);
        $productVariant->productVariantSubAttributesForSync()->detach();
        $productVariant->delete();
    }

    /**
     * @param Product    $product                        ürün id
     * @param array      $variantData                    variant array data
     * @param null|array $selectedVariantAttributeIDList seçili olan attribute list
     */
    public function saveProductVariants(Product $product, array $variantData, ?array $selectedVariantAttributeIDList): void
    {
        $variant = ProductVariant::urunHasVariant($product->id, $selectedVariantAttributeIDList, $variantData['currency']);
        if ($variant) {
            $variant->update($variantData);
            if ($variantData['id'] && $variant->id !== $variantData['id']) {
                ProductVariant::where('id', $variantData['id'])->delete();
            }
        } elseif ($variantData['id']) {
            $variant = ProductVariant::find($variantData['id']);
            $variant->update($variantData);
        } else {
            $variant = ProductVariant::create(array_merge($variantData, ['product_id' => $product->id]));
        }
        if ($variant) {
            $variant->productVariantSubAttributesForSync()->sync($selectedVariantAttributeIDList);
        }
    }

    public function getProductVariantPriceAndQty($product_id, $sub_attribute_id_list)
    {
        return ProductVariant::urunHasVariant($product_id, $sub_attribute_id_list);
    }

    public function deleteProductImage(int $id): bool
    {
        $productImage = ProductImage::find($id);
        if (null === $productImage) {
            return false;
        }
        $image_path = getcwd() . config('constants.image_paths.product_gallery_folder_path') . $productImage->image;
        $image_path_minify = getcwd() . config('constants.image_paths.product270x250_folder_path') . $productImage->image;
        if (file_exists($image_path)) {
            \File::delete($image_path);
            $productImage->delete();
        }
        if (\File::exists($image_path_minify)) {
            \File::delete($image_path_minify);
        }

        return true;
    }

    public function addProductImageGallery(int $product_id, array $image_files, Model $entry): bool
    {
        foreach ($image_files as $index => $file) {
            if ($index >= 9 || ! $file->isValid()) {
                continue;
            }
            $file_name = $product_id . '-' . Str::slug($entry->title) . Str::random(6) . '.jpg';
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(getimagesize($file)[0] / 2, getimagesize($file)[1] / 2);
            $image_resize->save(public_path(config('constants.image_paths.product_gallery_folder_path') . $file_name), ProductImage::IMAGE_QUALITY);
            ProductImage::create(['product' => $product_id, 'image' => $file_name]);
        }

        return true;
    }

    public function getProductsAndAttributeSubAttributesByFilter($category, $searchKey, $currentPage = 1, $selectedSubAttributeList = null, $selectedBrandIdList = null, $orderType = null)
    {
        // TODO : refactor
        return [];
    }

    public function getProductsBySearchTextForAjax(string $searchQuery)
    {
        $products = \Cache::remember('allActiveProductsWithKeyTitlePriceId', 60 * 24, function () {
            return Product::where('active', 1)->get(['id', 'title', 'price']);
        });

        return $products->filter(function ($value, $key) use ($searchQuery) {
            return true === str_contains($value->title, $searchQuery);
        });
    }

    public function getFeaturedProducts($categoryId = null, $qty = 10, $excludeProductId = null, $relations = null, $columns = ['*'])
    {
        if (null !== $categoryId) {
            return Product::select($columns)->when(null !== $relations, function ($query) use ($relations) {
                return $query->with($relations);
            })->when(null !== $excludeProductId, function ($query) use ($excludeProductId) {
                return $query->where('id', '!=', $excludeProductId);
            })->whereActive(1)->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->
            orderByDesc('id')->take($qty)->get();
        }

        return Product::select($columns)->when(null !== $relations, function ($query) use ($relations) {
            return $query->with($relations);
        })->when(null !== $excludeProductId, function ($query) use ($excludeProductId) {
            return $query->where(['id', '!=', $excludeProductId]);
        })->whereActive(1)->orderByDesc('id')->take($qty)->get();
    }

    public function getBestSellersProducts($categoryId = null, $qty = 9, $excludeProductId = null)
    {
        return \Cache::remember("bestSellersProducts{$categoryId}-{$qty}", 60 * 24, function () use ($excludeProductId, $qty, $categoryId) {
            $excludeProductQuery = $categoryQuery = '';
            if (null !== $excludeProductId) {
                $excludeProductQuery = " and u.id != {$excludeProductId}";
            }
            if (null !== $categoryId) {
                $categoryQuery = " and ku.category_id = {$categoryId}";
            }
            $query = "select u.title,SUM(su.qty) as qty,u.image,u.slug,u.tl_price,u.id,u.tl_discount_price,ud.product as detail
            from orders as  si
            inner join  baskets as s on si.basket_id = s.id
            inner join  basket_items as su on s.id = su.basket_id
            inner join products as u on u.active=1 and  su.product_id = u.id {$excludeProductQuery}
            inner join category_product as ku on ku.product_id = u.id {$categoryQuery}
            left join product_details ud on u.id = ud.product
            group by u.title,u.image,u.slug,u.tl_price,u.id,ud.product
            order by SUM(su.qty) DESC limit {$qty}";

            return collect(DB::select($query));
        });
    }

    public function filterProductsFilterBySelectedSubAttributeIdList($selectedSubAttributeList)
    {
        if (\is_array($selectedSubAttributeList) && @\count($selectedSubAttributeList) > 0) {
            $productIdList = [];
            $newProductIdList = [];
            foreach ($selectedSubAttributeList as $index => $item) {
                $productIdList[] = ProductDetail::whereHas('subDetails', function ($query) use ($item) {
                    $query->whereIn('sub_attribute', $item);
                })->pluck('product')->toArray();
                if (0 !== $index && $index !== \count($selectedSubAttributeList) && \count($selectedSubAttributeList) > 1) {
                    $newProductIdList = array_intersect($productIdList[$index - 1], $productIdList[$index]);
                    $productIdList[$index] = $newProductIdList;
                } else {
                    $newProductIdList = $productIdList[0];
                }
            }

            return $newProductIdList;
        }

        return null;
    }

    public function getProductDetailWithRelations(string $slug, array $relations = []): Product
    {
        return Product::with($relations)->whereSlug($slug)->whereActive(1)->withCount('comments')->first();
    }
}
