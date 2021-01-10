<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($languages as $langIndex => $language)
                <li class="{{ $langIndex == config('admin.default_language') ? 'active' : '' }}">
                    <a href="#tab_sub_attribute_{{ $index }}_{{ $langIndex }}_by_index" data-toggle="tab">
                        <img src="{{ langIcon($language[0]) }}"/>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @php
                $descIndex = 0;
            @endphp
            @foreach($languages as $langIndex => $language)
                <div class="tab-pane {{ $langIndex == config('admin.default_language') ? 'active' : '' }}" id="tab_sub_attribute_{{ $index  }}_{{ $langIndex }}_by_index">
                    <div class="row productSubAttribute" data-index="{{$index}}">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Başlık {{ $langIndex }}</label>
                            @if($langIndex == config('admin.default_language'))
                                <input type="hidden" name="main_product_sub_attribute_id_{{$index}}" value="0">
                                <input type="text" class="form-control" name="main_product_sub_attribute_title_{{$index}}">
                            @else
                                <input type="hidden" name="product_sub_attribute_id_{{ $index }}_{{ $descIndex }}" value="0">
                                <input type="hidden" name="product_sub_attribute_lang_{{$index }}_{{$descIndex}}" value="{{ $language[0]  }}">
                                <input type="text" class="form-control" name="product_sub_attribute_title_{{ $index }}_{{$descIndex}}">
                                @php
                                    $descIndex++;
                                @endphp
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
        <!-- /.tab-content -->
    </div>
</div>
