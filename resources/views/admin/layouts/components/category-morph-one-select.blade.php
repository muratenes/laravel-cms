<x-select
    name="category_id"
    label="Kategori"
    :options="$categories->toArray()" width="6"
    :value="$item->category_id"
    onchange="countryOnChange(this)"
    required
/>
<x-select
    name="category_id"
    label="Alt Kategori"
    :options="$subCategories" width="6"
    :value="$item->sub_category_id"
/>

{{--<x-select name="country_id" label="Ülke" :options="$countries" width="12" :value="$item->country_id" onchange="countryOnChange(this)" required/>--}}
