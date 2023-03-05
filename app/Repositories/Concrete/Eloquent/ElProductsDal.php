<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\CategoryProduct;
use App\Models\Kategori;
use App\Models\Product\Product;
use App\Models\Product\ProductAttribute;
use App\Models\Product\ProductBrand;
use App\Models\Product\ProductDetail;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductInfo;
use App\Models\Product\ProductSubAttribute;
use App\Models\Product\ProductSubDetail;
use App\Models\Product\ProductVariant;
use App\Models\Product\ProductVariantSubAttribute;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ElProductsDal implements ProductInterface
{
    use ResponseTrait;

    protected $model;
    protected $productAttributeService;
    protected $productSubAttributeService;
    protected $categoryService;

    public function __construct(Product $model, ProductAttribute $urunAttributeService, ProductSubAttribute $urunSubAttributeService, Kategori $categoryService)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
        $this->productAttributeService = app()->makeWith(ElBaseRepository::class, ['model' => $urunAttributeService]);
        $this->productSubAttributeService = app()->makeWith(ElBaseRepository::class, ['model' => $urunSubAttributeService]);
        $this->categoryService = app()->makeWith(ElBaseRepository::class, ['model' => $categoryService]);
    }

    public function all($filter = null, $columns = ['*'], $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get($columns);
    }

    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = ['*'], $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
        if (null === $columns) {
            $columns = ['*'];
        }

        return Product::select($columns)->where($field, $value)->when(null !== $relations, function ($query) use ($relations) {
            return $query->with($relations);
        })->withCount('activeComments')->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        $record = $this->getById($id, null, ['images', 'categories', 'favorites', 'commentsForDelete']);
        $record->detail()->delete();
        $record->categories()->detach();
        $record->favorites()->detach();
        $record->commentsForDelete()->delete();
        $deleteImages = [];
        $image_path_minify = getcwd() . config('constants.image_paths.product270x250_folder_path') . $record->image;
        $image_path = getcwd() . config('constants.image_paths.product_image_folder_path') . $record->image;
        array_push($deleteImages, $image_path_minify, $image_path);
        foreach ($record->images as $img) {
            $deleteImages[] = (getcwd() . config('constants.image_paths.product_gallery_folder_path') . $img->image);
        }
        foreach ($deleteImages as $di) {
            if (file_exists($di)) {
                \File::delete($di);
            }
        }
        $record->delete();

        return $record;
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
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

    public function updateWithCategory(array $productData, int $id, array $categories, array $selected_attributes_and_sub_attributes = null)
    {
        $entry = $this->getById($id);
        if (!isset($productData['code']) && config('admin.product.auto_code')) {
            $productData['code'] = (int)($entry->id . rand(1000, 999999));
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
            $code = $productData['code'] ?: (config('admin.product_auto_code') ? (int)(rand(1000, 999999)) : null);
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


    public function getAllAttributes()
    {
        return $this->productAttributeService->all(['active' => 1])->get();
    }

    public function getAllSubAttributes()
    {
        return ProductSubAttribute::whereHas('attribute', function ($query) {
            $query->where('active', 1);
        })->get();
    }

    public function getSubAttributesByAttributeId(int $id)
    {
        return $this->productSubAttributeService->all([['parent_attribute', $id]])->get();
    }

    public function deleteProductDetail($detailId)
    {
        try {
            $productDetail = ProductDetail::with('product.variants')->findOrFail($detailId);

            $productId = $productDetail->product;
            $subAttributeIdList = $productDetail->attribute->subAttributes->pluck('id');
            $productVariantsIdList = Product::with('variants')->whereId($productId)->first()->variants()->pluck('id');
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

            return 'true';
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function getProductDetailWithSubAttributes($productId)
    {
        $product = $this->getById($productId, ['id', 'title'], 'detail.subDetails.parentSubAttribute');
        foreach ($product->detail as $de) {
            $de['parent_title'] = $de->attribute->title;
        }

        return $product->toArray();
    }

    public function deleteProductVariant(int $variantId)
    {
        $productVariant = ProductVariant::findOrFail($variantId);
        $productVariant->productVariantSubAttributesForSync()->detach();
        $productVariant->delete();
    }

    /**
     * @param Product $product ürün id
     * @param array $variantData variant array data
     * @param null|array $selectedVariantAttributeIDList seçili olan attribute list
     */
    public function saveProductVariants(Product $product, array $variantData, ?array $selectedVariantAttributeIDList)
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

    public function deleteProductImage($id)
    {
        $productImage = ProductImage::find($id);
        if (null === $productImage) {
            return $id . ' id li resim bulunamadı';
        }
        $image_path = getcwd() . config('constants.image_paths.product_gallery_folder_path') . $productImage->image;
        $image_path_minify = getcwd() . config('constants.image_paths.product270x250_folder_path') . $productImage->image;
        if (file_exists($image_path)) {
            \File::delete($image_path);

            $productImage->delete();

            return 'true';
        }
        if (\File::exists($image_path_minify)) {
            \File::delete($image_path_minify);
        }

        return $image_path;
    }

    public function addProductImageGallery($product_id, $image_files, $entry)
    {
        foreach (request()->file('imageGallery') as $index => $file) {
            if ($index < 10) {
                if ($file->isValid()) {
                    $file_name = $product_id . '-' . Str::slug($entry->title) . Str::random(6) . '.jpg';
                    $image_resize = Image::make($file->getRealPath());
                    $image_resize->resize(getimagesize($file)[0] / 2, getimagesize($file)[1] / 2);
                    $image_resize->save(public_path(config('constants.image_paths.product_gallery_folder_path') . $file_name), ProductImage::IMAGE_QUALITY);
                    ProductImage::create(['product' => $product_id, 'image' => $file_name]);
                }
            } else {
                session()->flash('message', 'ürüne ait en fazla 10 adet resim yükleyebilirsiniz');
                session()->flash('message_type', 'danger');

                break;
            }
        }

        return true;
    }

    public function getProductsAndAttributeSubAttributesByFilter($category, $searchKey, $currentPage = 1, $selectedSubAttributeList = null, $selectedBrandIdList = null, $orderType = null)
    {
        $filteredProductIdList = $this->filterProductsFilterBySelectedSubAttributeIdList($selectedSubAttributeList);
        $products = Product::with('detail')->where([['title', 'like', "%{$searchKey}%"], ['active', '=', 1]])->when(null !== $category, function ($query) use ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $category = Kategori::with('sub_categories')->find($category);
                if (null !== $category) {
                    $sub_categories = $category->sub_categories->pluck('id')->toArray();
                    $sub_categories[] = $category->id;
                    $query->whereIn('category_id', $sub_categories);
                }
            });
        })->when(null !== $selectedBrandIdList, function ($q) use ($selectedBrandIdList) {
            $q->whereHas('info', function ($query) use ($selectedBrandIdList) {
                $query->whereIn('brand_id', $selectedBrandIdList);
            });
        })->when(null !== $filteredProductIdList, function ($q) use ($filteredProductIdList) {
            $q->whereIn('id', $filteredProductIdList);
        })->orderBy(Product::getProductOrderType($orderType)[0], Product::getProductOrderType($orderType)[1]);
        $productIdList = $products->pluck('id')->toArray();
        $productTotalCount = Product::whereIn('id', $productIdList)->select('id')->whereIn('id', $productIdList)->count();
        $totalPage = ceil($productTotalCount / Product::PER_PAGE);
        $productDetails = ProductDetail::select('parent_attribute', 'id')->with('subDetails')->whereIn('product', $productIdList);
        $attributesIdList = $productDetails->pluck('parent_attribute');
        $attributes = ProductAttribute::getActiveAttributesWithSubAttributesCache()->find($attributesIdList);
        $categories = CategoryProduct::select('category_id')->whereIn('product_id', $productIdList)->distinct('category_id')->pluck('category_id')->toArray();
        $categories = Kategori::getCache()->whereIn('id', $categories);
        $subAttributesIdList = ProductSubDetail::select('sub_attribute')->whereIn('parent_detail', $productDetails->pluck('id'))->pluck('sub_attribute');
        $subAttributes = ProductSubAttribute::getActiveSubAttributesCache()->find($subAttributesIdList);
        $brandIdList = ProductInfo::select('brand_id')->whereNotNull('brand_id')->whereIn('product_id', $productIdList)->distinct('brand_id')->get()->pluck('brand_id')->toArray();
        $brands = array_values(ProductBrand::getActiveBrandsCache()->find($brandIdList)->toArray());
        $products = $products->skip((1 !== $currentPage ? ($currentPage - 1) : 0) * Product::PER_PAGE)->take(Product::PER_PAGE)->get();

        return [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'totalPage' => 0 !== $totalPage ? $totalPage : 1,
            'productTotalCount' => $productTotalCount,
            'subAttributes' => $subAttributes,
            'returnedSubAttributes' => $subAttributes->pluck('id')->toArray(),
            'filterSideBarAttr' => $attributes->pluck('id')->toArray(),
            'per_page' => Product::PER_PAGE,
            'current_page' => (int)(0 !== $currentPage ? $currentPage : 1),
        ];
    }

    public function getProductsBySearchTextForAjax($searchQuery)
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

    public function getProductDetailWithRelations($slug, $relations)
    {
        return Product::with($relations)->whereSlug($slug)->whereActive(1)->withCount('comments')->first();
    }

    /**
     * gönderilen ürünün istenilen dildeki karşılık gelen kategorilerini bulur.
     *
     * @param Product $product
     * @param int $lang istenilen dildeki kategoriler
     *
     * @return null|array
     */
    public function getProductCategoriesByLanguage(Product $product, int $lang)
    {
        $defaultLanguageCategoriesIDs = $product->categories->pluck('id')->toArray();

        return Kategori::whereIn('main_category_id', $defaultLanguageCategoriesIDs)->where('lang', $lang)->get()->pluck('id')->toArray();
    }
}
