<label for="categories">Kategoriler</label>
<select name="categories[]" id="categories" class="form-control" multiple required>
    <option value="">---Kategori Seçiniz --</option>
    @foreach($categories as $cat)
        <option {{ collect(old('categories',$selected_categories))->contains($cat->id) ? 'selected' : '' }}
                value="{{ $cat->id }}">{{ $cat->title }}</option>
    @endforeach
</select>
