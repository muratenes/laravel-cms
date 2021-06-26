<?php

namespace App\Utils\Excel\Imports;

use App\Models\Ayar;
use App\Models\Kategori;
use App\Models\Product\Urun;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImports implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $properties = [];

        foreach ($rows as $row) {
            $product = Urun::where('title', $row['title'])->first();
            $keywords = $row['keys'] ? explode(',', $row['keys']) : [];
            $category = $this->checkCategoryAndSubCategory($row);
            if ($product) {
                $product->update([
                    'properties'         => $properties,
                    'spot'               => mb_substr($row['short_description'], 0, 255),
                    'tags'               => $keywords,
                    'parent_category_id' => $category['parent_category_id'],
                    'sub_category_id'    => $category['sub_category_id'],
                ]);
            } else {
                $product = Urun::create([
                    'title'              => $row['title'],
                    'slug'               => Str::slug($row['title']),
                    'spot'               => mb_substr($row['short_description'], 0, 255),
                    'properties'         => $properties,
                    'tags'               => $keywords,
                    'parent_category_id' => $category['parent_category_id'],
                    'sub_category_id'    => $category['sub_category_id'],
                ]);
            }
            // multiple category
            if (config('admin.product.multiple_category') && isset($row['categories']) && $row['categories']) {
                $this->syncCategories($row['categories'], $product);
            }
            //image
            if ($row['image']) {
                if (Storage::exists('excel/products/images/' . $row['image'])) {
                    $file = Storage::get('excel/products/images/' . $row['image']);
                    Storage::put('public/products/' . $row['image'], $file);
                    $product->update(['image' => $row['image']]);
                }
            }
            // gallery
            $this->uploadGalleryImages($product, $row);

            // update/create other languages
            $this->syncLanguages($product, $properties, $row);
        }
    }

    /**
     * get category and sub_category from excel row.
     *
     * @param array $row excel row
     *
     * @return array
     */
    private function checkCategoryAndSubCategory($row): array
    {
        $data = [
            'parent_category_id' => null,
            'sub_category_id'    => null,
        ];
        if (config('admin.product.multiple_category') || ! isset($row['parent_category']) || ! $row['parent_category']) {
            return $data;
        }

        $data['parent_category_id'] = Kategori::firstOrCreate(['title' => $row['parent_category']]);
        if ($row['sub_category']) {
            $data['sub_category_id'] = Kategori::firstOrCreate(['parent_category_id' => $data['parent_category_id'], 'title' => $row['sub_category']]);
        }

        return $data;
    }

    /**
     * çoklu kategorileri ekleme/güncelleme için kullanılır.
     *
     * @param $rowCategories
     * @param Urun $product
     *
     * @return array
     */
    private function syncCategories($rowCategories, Urun $product)
    {
        $categoryTitles = explode(',', $rowCategories);
        foreach ($categoryTitles as $catTitle) {
            $hasParent = mb_strpos($catTitle, '(');
            if ($hasParent > -1) {
                $parentCategoryTitle = mb_strtolower(str_replace(['(', ')'], '', mb_substr($catTitle, $hasParent, \mb_strlen($catTitle))));
                $subCategoryTitle = mb_strtolower(mb_substr($catTitle, 0, $hasParent));

                $parentCategory = Kategori::firstOrCreate(['title' => $parentCategoryTitle], ['slug' => Str::slug($parentCategoryTitle ?? Str::random(12))]);
                $subCategory = $parentCategory->sub_categories()->firstOrCreate(
                    ['title' => $subCategoryTitle],
                    ['slug' => Str::slug($parentCategoryTitle ? "{$parentCategoryTitle}-{$subCategoryTitle}" : Str::random(12))]
                );

                $product->update([
                    'parent_category_id' => $parentCategory->id,
                    'sub_category_id'    => $subCategory->id,
                ]);
            } else {
                $category = Kategori::firstOrCreate(
                    ['title' => $catTitle],
                    ['slug' => Str::slug($catTitle ?? Str::random(12))]
                );
                $product->update(['parent_category_id' => $category->id]);
            }
        }
    }

    /**
     * ürünlerin diğer dillerdeki karşılıklarının günceller.
     *
     * @param Urun $product
     * @param $properties
     * @param $row
     */
    private function syncLanguages(Urun $product, $properties, $row)
    {
        foreach (Ayar::languages() as $language) {
            $title = $row["title_${language[3]}"] ?? null;
            if ($title) {
                $product->descriptions()->updateOrCreate([
                    'lang' => $language[0],
                ], [
                    'title'      => $title,
                    'slug'       => Str::slug($title),
                    'spot'       => mb_substr($row["short_description_${language[3]}"], 0, 255),
                    'product_id' => $product->id,
                    'properties' => $properties,
                ]);
            }
        }
    }

    /**
     * product gallery upload images.
     *
     * @param Urun $product
     * @param $row
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function uploadGalleryImages(Urun $product, $row)
    {
        for ($i = 1; $i < 5; $i++) {
            $imageName = $row["image{$i}"];
            if ($imageName && Storage::exists('excel/products/images/' . $imageName) && $imageName) {
                $file = Storage::get('excel/products/images/' . $imageName);
                Storage::put('public/product-gallery/' . $imageName, $file);
                $product->images()->updateOrCreate([
                    'image' => $imageName,
                ]);
            }
        }
    }
}
