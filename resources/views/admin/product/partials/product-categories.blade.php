@if(admin('modules.product.multiple_category'))
    <div class="form-group col-md-4">
        <label for="exampleInputEmail1">Kategoriler</label>
        <select name="categories[]" id="categories" class="form-control" multiple required>
            <option value="">---Kategori Seçiniz --</option>
            @foreach($data['categories'] as $cat)
                <option {{ collect(old('categories',$data['selected']['categories']))->contains($cat->id) ? 'selected' : '' }}
                        value="{{ $cat->id }}" title="{{ $cat->main_category->title ?? $cat->title }}">
                    {{ $cat->title }} {{  $cat->main_category ? "({$cat->main_category->title})" : "" }}
                </option>
            @endforeach
        </select>
    </div>
@else
<!-- ALT/UST KATEGORİ -->
<div class="form-group col-md-2">
    <label for="exampleInputEmail1">Üst Kategori</label>
    <select name="parent_category_id" id="parent_category_id" class="form-control" required>
        <option value="">---Üst Kategori Seçiniz --</option>
        @foreach($data['categories'] as $cat)
            <option {{ $product->parent_category_id == $cat->id ? 'selected' : '' }}
                    value="{{ $cat->id }}">{{ $cat->title }}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-2">
    <label>Alt Kategori</label>
    <select name="sub_category_id" id="sub_category_id" class="form-control">
        <option value="">---Alt Kategori Seçiniz --</option>
        @foreach($data['subCategories'] as $subCat)
            <option {{ $product->sub_category_id == $subCat->id ? 'selected' : '' }}
                    value="{{ $subCat->id }}">{{ $subCat->title }}</option>
        @endforeach
    </select>
</div>
@endif


